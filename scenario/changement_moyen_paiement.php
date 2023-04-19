<?php
require_once("../resttbs.php");
header( 'content-type: text/html; charset= utf-8' );

// /!\ *******  Limitation ****** /!\
// 1- Seuls les abonnements à durée libre sont eligibles (ADL)
// 2- Seul les abonnements dont les offres sont en multipaiement CB / SEPA (typeReglement=8) sont eligibles
// 3- Si il y a un chainage d'offre au cours des reconductions ADL, l'abonnement devra être arrivé sur la dernière offre pour être eligible

initHTML();

$codeClient=1474801;//Client concerné par le changement de moyen de paiement
$refAbonnement=1581094; // Reference d'un des abonnements dont le moyen de paiement est à changer


// TRAITEMENT DES CALL API

$token = getToken(LOGIN, CREDENTIAL, false);

//Lecture de l'abonnement
$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/".$refAbonnement, $token);

// Verification de l'éligibilité de l'abonnement au changement du moyen de paiement
if(property_exists($response, 'value') && $response->value !== null) {
	$abonnement = $response->value;
	$aboEligible = false;
	if( $abonnement->codeClient == $codeClient && 
		$abonnement->obsolete == false &&
		$abonnement->adl == true) {
		//Abonnement eligible

		//Lecture du tarif de formule pour vérifier l'éligibilité
		$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/".$abonnement->refTarifFormule, $token);

		// Verification de l'éligibilité de l'abonnement au changement du moyen de paiement
		if(property_exists($response, 'value') && $response->value !== null) {
			$formule = $response->value;
			if( $formule->typeReglement == 8) {
				if($formule->nbChainages == 0 && $formule->refTarifReabo == null){
					if($abonnement->typeReglement == 6) { //Type Prel CB
						$refMandat = 85258; // référence du nouveau mandat associé au client - valeur retournée via https://github.com/GitMahalo/mahalo-php-v3/blob/master/mandat/creationMandat.php
						print_rr("----------------------------------------");
						print_rr("-- Abonnement eligible => Changement de CB vers SEPA autorisé --");
						print_rr("-- Prévoir enregistrement du mandat à cette étape --");
						print_rr("-- Le mandat sera activé lors de la validation du premier réabonnement via l'installation de la commande --");
						print_rr("----------------------------------------");
						print_rr("");
						print_rr("Enregistrement du mandat OK => refMandat = ".$refMandat);
						$aboEligible = true;
					} else if($abonnement->typeReglement == 2) { //Type Prel SEPA
						$refCb = 999999;
						print_rr("----------------------------------------");
						print_rr("-- Abonnement eligible => Changement de SEPA vers CB autorisé --");
						print_rr("-- Prévoir enregistrement de la CB à cette étape --");
						print_rr("----------------------------------------");
						print_rr("");
						print_rr("Enregistrement du mandat OK => refCb = ".$refCb);
						$aboEligible = true;
					} else {
						print_rr("Abonnement non eligible : typeReglement = ".$abonnement->typeReglement);
					}
			
					if($aboEligible) {
			
						// Creation du tampon client
						$commandeDuclient["codeClient"] = $codeClient;  //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
						$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client (e utiliser uniquement si le codeClient est passe en parametre)
						$commandeDuclient["refSociete"] = $formule->refSociete; //Obligatoire identifiant de la societe
						$commandeDuclient["lignesCommande"] = array();
		
						//Creation d'une ligne de commande d'abonnement
						$ligneCommande0["refTarif"] = $abonnement->refTarifFormule; // meme formule que precedemment
						$ligneCommande0["quantite"] = $abonnement->nbExemplaires; // meme quantite que precedement
						$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
						$ligneCommande0["refAboEchu"] = $abonnement->refAbonnement; //Pour faire un réabonnement suite au précédent et garder la cohérence
						//TRAITEMENT DES CALL API
		
						if(isset($refCb)){
							print_rr("Creation d'une nouvelle commande de type CB avec comme reference l'ancien abo ".$abonnement->refAbonnement);
							$ligneCommande0["modePaiement"] = 6; //6 pour prelevement sur CB. La commande sera integree avec generation d'une facture non soldee et X prelevements en fonction des parametrages du tarif
							$commandeDuclient["refCb"] = $refCb; 
						} else if(isset($refMandat)){
							print_rr("Creation d'une nouvelle commande de type SEPA avec comme reference l'ancien abo ".$abonnement->refAbonnement);
							$ligneCommande0["modePaiement"] = 3; //3 pour prelevement sur MANDAT. La commande sera integree avec generation d'une facture non soldee et X prelevements en fonction des parametrages du tarif
							$commandeDuclient["refMandat"] = $refMandat; 
						}
						$commandeDuclient["lignesCommande"][] = $ligneCommande0;
		
						//Insertion de la commande
						print_rr("Insertion de la commande");
						$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
						if(property_exists($response, 'value')) {
		
							print_rr("Reference de la commande = ".$response->value->noCommande);
		
							print_rr("Validation de la commande");
							$commandes = [];
							$commandes[] = $response->value->noCommande;
							$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
						}
					}
					print_rr("ok");
				} else {
					print_rr("Vous êtes sur une offre qui va évoluer, vous ne pouvez changer le moyen de paiement sur cette offre tant que vous n'êtes pas dans sa configuration définitive.");	
				}
			} else {
				print_rr("Formule incompatible ".$formule->codeTarif);
			}
		}
	}
	if($aboEligible == false) {
		print_rr("Abonnement non eligible ".$abonnement->refAbonnement);
	}
}

endHTML();

?>
