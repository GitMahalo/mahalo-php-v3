<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 543283; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client (e utiliser uniquement si le codeClient est passe en parametre)
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement prepaye (tarif d'abonnement gratuit dans Aboweb)
	$ligneCommande0["refTarif"] = 12; // reference unique de l'abonnement gratuit correspondant e 5euro de carte cadeau obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande0["typeAdresseLiv"] = 5; //Creation d'une adresse temporaire utilise uniquement pour la commande
	$ligneCommande0["civiliteLiv"] = 'M';
	$ligneCommande0["nomLiv"] = 'LABAS';
	$ligneCommande0["prenomLiv"] = 'LOIN';
	$ligneCommande0["adresse2Liv"] = '22 AV DE LA GARE';
	$ligneCommande0["cpLiv"] = '1000000';
	$ligneCommande0["villeLiv"] = 'PEKIN';
	$ligneCommande0["codeIsoPaysLiv"] = "CN";
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	$ligneCommande = array();
	$ligneCommande[0] = $ligneCommande0;

	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);

	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";


	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}
?>
