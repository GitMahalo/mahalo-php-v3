<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "5019007"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	
	$commandeDuclient["nePasModifierClient"] = 1; // 0 = permet de modifier les donnees client lors de la validation de la commande

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["pns"] = 6400;
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";


	if(VALIDATION_COMMANDE) {
		print "Validation de la commande";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
