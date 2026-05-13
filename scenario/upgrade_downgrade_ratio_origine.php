<?php
require_once("../resttbs.php");

// /!\ *******  Limitations ****** /!\
// 1- L'abonnement doit être facturé (refFacture != null)
// 2- La facture doit être soldée (solde = 0)
// 3- L'abonnement doit être en cours (etat = "01")

initHTML();

// ========================================
// VARIABLES DE CONFIGURATION
// ========================================
$codeClient = 2120527; // Client concerné par l'upgrade/downgrade du ratio
$refAbonnement = 295771; // Reference d'un des abonnements dont le ratio est à modifier
$formuleCible = 1328; // Formule cible pour l'upgrade/downgrade
$udAction = true; // upgrade/downgrade action
$reaboAction = false; // reabonnement action
$typeReglement = 1; // Type de réglement (à adapter selon le type)

print_rr("========================================");
print_rr("PARAMETRES D'EXECUTION");
print_rr("========================================");
print_rr("REF_EDITEUR = ".REF_EDITEUR);
print_rr("codeClient = ".$codeClient);
print_rr("refAbonnement = ".$refAbonnement);
print_rr("formuleCible = ".$formuleCible);
print_rr("LOGIN = ".LOGIN);
print_rr("========================================");
print_rr("");

// TRAITEMENT DES CALL API

$token = BEARERTOKEN;
print_rr("Token utilisé : ".(!empty($token) ? 'OK ('.substr($token, 0, 20).'...)' : 'ERREUR - Token vide'));

// Lecture de l'abonnement
print_rr("Lecture de l'abonnement : refAbonnement = ".$refAbonnement);
$url = "/editeur/".REF_EDITEUR."/abonnement/".$refAbonnement;
print_rr("URL complète : https://localhost:8443/aboweb-ws".$url);
print_rr("Token : ".substr($token, 0, 20)."...");
print_rr("");

$response = callApiGet($url, $token);

if($response === null || !is_object($response)) {
	print_rr("ERREUR : Réponse invalide de l'API");
	print_rr("Vérifier : refAbonnement (".$refAbonnement."), token, et REF_EDITEUR");
	print_rr("L'abonnement 295771 existe-t-il ?");
	endHTML();
	exit;
}

// Vérification de l'éligibilité de l'abonnement à l'upgrade/downgrade du ratio
if(property_exists($response, 'value') && $response->value !== null) {
	$abonnement = $response->value;
	$aboEligible = false;

	if( $abonnement->codeClient == $codeClient &&
		$abonnement->etat == "01") {

		// Vérification que l'abonnement est bien facturé
		if(property_exists($abonnement, 'refFacture') && $abonnement->refFacture !== null) {

			// Lecture de la facture pour vérifier qu'elle est soldée
			$response = callApiGet("/editeur/".REF_EDITEUR."/facture/".$abonnement->refFacture, $token);

			if(property_exists($response, 'value') && $response->value !== null) {
				$facture = $response->value;

				// Vérification que la facture est soldée (solde = 0)
				if($facture->solde == 0) {
					print_rr("----------------------------------------");
					print_rr("-- Abonnement eligible => Upgrade/Downgrade du ratio autorisé --");
					print_rr("-- refAbonnement = ".$abonnement->refAbonnement);
					print_rr("-- refFacture = ".$abonnement->refFacture);
					print_rr("-- Solde facture = ".$facture->solde);
					print_rr("----------------------------------------");
					print_rr("");
					$aboEligible = true;

					if($aboEligible) {
						// Paramètres pour l'appel API de prorata
						$refAbonnementAbo = $abonnement->refAbonnement;
						$refTarif = $formuleCible;
						$codeClientAbo = $abonnement->codeClient;
						$nbExemplaires = $abonnement->nbExemplaires;

						// Préparation du body avec l'abonnement
						$prorataData = array(
							"abonnements" => array($abonnement),
							"articleLignes" => array(),
							"ratioSurOrigine" => true
						);

						print_rr("Appel API /credit/prorata/prepare");
						$prorataUrl = "/editeur/".REF_EDITEUR."/credit/prorata/prepare?refAbonnement=".$refAbonnementAbo.
							"&udAction=".($udAction ? 'true' : 'false').
							"&reaboAction=".($reaboAction ? 'true' : 'false').
							"&typeReglement=".$typeReglement.
							"&refTarif=".$refTarif.
							"&codeClient=".$codeClientAbo.
							"&nbExemplaires=".$nbExemplaires;

						$response = callApiPost($prorataUrl, $token, $prorataData);

						if(property_exists($response, 'value')) {
							$prorataResult = $response->value;
							print_rr("");
							print_rr("========================================");
							print_rr("POINT D'ARRET - ETAPE 1 VALIDEE");
							print_rr("========================================");
							print_rr("Décommenter la ligne ci-dessous pour continuer vers l'étape 2 (Création formule)");
							print_rr("");

							// POINT D'ARRET - Commenter la ligne ci-dessous pour continuer
							// endHTML();
							// exit;

							// Création de la formule avec les abonnements proratisés
							print_rr("Création de la formule...");

							$formuleData = array(
								"formule" => array(
									"refFormule" => null,
									"codeClient" => $codeClient,
									"refTarif" => $formuleCible,
									"abonnements" => $prorataResult->abonnements,
									"articleLignes" => array(),
									"articles" => array(),
									"refSociete" => $abonnement->refSociete,
									"refTitre" => $abonnement->refTitre,
									"codeTarif" => isset($abonnement->codeTarifFormule) ? $abonnement->codeTarifFormule : null,
									"designationTarif" => isset($abonnement->designationTarifFormule) ? $abonnement->designationTarifFormule : null,
									"titreEnClair" => $abonnement->titreEnClair,
									"nomAbonne" => $abonnement->nomAbonne,
									"nbExemplaires" => $abonnement->nbExemplaires,
									"montantTtc" => $prorataResult->montantTtc,
									"avoirOn" => false,
									"isUpgradeDowngrade" => true
								),
								"refAncienAbo" => $abonnement->refAbonnement,
								"isUpgradeDowngrade" => true,
								"createFacture" => true,
								"typeReglement" => "1"
							);

							$response = callApiPost("/editeur/".REF_EDITEUR."/formule", $token, $formuleData);

							if(property_exists($response, 'value')) {
								$formuleResult = $response->value;
								print_rr("");

								// Vérification que la facture a bien été créée automatiquement
								if(!property_exists($formuleResult, 'refFacture') || $formuleResult->refFacture === null) {
									print_rr("ERREUR : La facture n'a pas été créée lors de la création de la formule");
									endHTML();
									exit;
								}

								$refFacture = $formuleResult->refFacture;
								print_rr("Facture créée automatiquement : refFacture = ".$refFacture);
								print_rr("");
								print_rr("========================================");
								print_rr("POINT D'ARRET - ETAPE 2 VALIDEE");
								print_rr("========================================");
								print_rr("Décommenter la ligne ci-dessous pour continuer vers l'étape 3 (Lecture Facture)");
								print_rr("");

								// POINT D'ARRET - Commenter la ligne ci-dessous pour continuer
								// endHTML();
								// exit;

								// Lecture de la facture créée
								print_rr("Lecture de la facture créée...");
								print_rr("");

								$response = callApiGet("/editeur/".REF_EDITEUR."/facture/".$refFacture, $token);

								if(property_exists($response, 'value')) {
									$factureCreee = $response->value;
									print_rr("");
									print_rr("========================================");
									print_rr("POINT D'ARRET - ETAPE 3 VALIDEE");
									print_rr("========================================");
									print_rr("Décommenter la ligne ci-dessous pour continuer vers l'étape 4 (Création Règlement)");
									print_rr("");

									// POINT D'ARRET - Commenter la ligne ci-dessous pour continuer
									// endHTML();
									// exit;

									// Création du règlement pour solder la facture
									if($factureCreee->solde > 0) {
										print_rr("Création du règlement pour solder la facture...");
										print_rr("");

										$dateReglement = date('c');
										$montantRegle = $factureCreee->solde;

										$reglementData = array(
											"refReglement" => null,
											"nomDebiteur" => $abonnement->nomAbonne,
											"typeReglement" => "1",
											"dateReglement" => $dateReglement,
											"dateReglementInitial" => null,
											"montantRegle" => $montantRegle,
											"refModePaiement" => 64,
											"refBanque" => 1,
											"refFacture" => $refFacture,
											"refAbonnement" => null,
											"refSociete" => $abonnement->refSociete,
											"codeClient" => $codeClient,
											"nbPrelevements" => 1,
											"frequencePrelevement" => 1,
											"frequencePrelevementUnite" => 1,
											"titulaire" => null,
											"banque" => null,
											"rum" => null,
											"bic" => null,
											"iban" => null,
											"cs1Reg" => null,
											"nomBanque" => null,
											"libelle" => null,
											"refTitre" => $abonnement->refTitre,
											"tauxTva" => null,
											"passeEnCompta" => false,
											"simulerCompta" => false,
											"prelevementOk" => false,
											"etatReglement" => "2",
											"dateAuto" => null,
											"numBordereau" => null,
											"solderFacture" => null,
											"creerCredit" => null,
											"cbIdPsp" => null,
											"sequenceGroupe" => null,
											"reglementGroupe" => false,
											"refMandat" => null,
											"libRejet" => null,
											"reactiverAbonnements" => null,
											"creationPrelAVenir" => false
										);

										$response = callApiPost("/editeur/".REF_EDITEUR."/reglement?creationPrelevementsAVenir=false", $token, $reglementData);

										if(property_exists($response, 'value')) {
											$reglementResult = $response->value;
											print_rr("----------------------------------------");
											print_rr("Règlement créé avec succès");
											print_rr("----------------------------------------");
											print_rr("Référence Règlement : ".$reglementResult->refReglement);
											print_rr("Montant Réglé : ".$reglementResult->montantRegle);
											print_rr("État Règlement : ".$reglementResult->etatReglement);
											print_rr("Facture : ".$reglementResult->refFacture);
											print_rr("----------------------------------------");
											print_rr("OK");
										} else {
											print_rr("Erreur lors de la création du règlement");
											if(property_exists($response, 'errorMessage')) {
												print_rr("Message d'erreur : ".$response->errorMessage);
											}
										}
									} else {
										print_rr("Facture déjà soldée - Aucun règlement à créer");
										print_rr("Solde : ".$factureCreee->solde);
									}
								} else {
									print_rr("Erreur lors de la lecture de la facture");
									if(property_exists($response, 'errorMessage')) {
										print_rr("Message d'erreur : ".$response->errorMessage);
									}
								}
							} else {
								print_rr("Erreur lors de la création de la formule");
								if(property_exists($response, 'errorMessage')) {
									print_rr("Message d'erreur : ".$response->errorMessage);
								}
							}
						} else {
							print_rr("Erreur lors de la préparation du prorata");
						}
					}
				} else {
					print_rr("Abonnement non eligible : La facture n'est pas soldée (solde = ".$facture->solde.")");
				}
			} else {
				print_rr("Abonnement non eligible : Facture non trouvée (refFacture = ".$abonnement->refFacture.")");
			}
		} else {
			print_rr("Abonnement non eligible : Abonnement non facturé (refFacture = null)");
		}
	} else {
		if($abonnement->codeClient != $codeClient) {
			print_rr("Abonnement non eligible : Code client différent");
		}
		if($abonnement->etat != "01") {
			print_rr("Abonnement non eligible : Abonnement non en cours (etat = ".$abonnement->etat.")");
		}
	}

	if($aboEligible == false) {
		print_rr("Abonnement non eligible ".$abonnement->refAbonnement);
	}
}

endHTML();

?>
