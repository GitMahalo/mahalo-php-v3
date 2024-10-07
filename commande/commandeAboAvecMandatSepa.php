<?php
	require_once("../resttbs.php");

	/*Apres retour STRIPE pour creation du MANDAT - envoyer le TOKEN a MAHALO pour creation MANDAT dans MAHALO*/
	/*le premier prelevement sera éxécuté par MAHALO en fonction de la configuration en plac. */

	//Le prestaire de paiement SEPA est selectionné automatiquement en fonction du parametrage dans MAHALO
	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "33792"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	$commandeDuclient["refMandat"] = 1111; // référence du mandat associé au client - valeur retournée via https://github.com/GitMahalo/mahalo-php-v3/blob/master/mandat/creationMandat.php
	// solution obsolète : renseigné le bic/iban
	//$commandeDuclient["bic"] = "BDFEFR2L"; 
	//$commandeDuclient["iban"] = "FR7630001007941234567890185";
	
	$commandeDuclient["nePasModifierClient"] = 1; // permet de modifier les donnees client lors de la validation de la commande lorsque ca vaut 0

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();


	//Creation d'une ligne de commande d'abonnement
	
	// Soit refTarif soit codeTarif obligatoire
	// $ligneCommande0["refTarif"] = 4; // reference unique du tarif obtenu par l'api tarif
	$ligneCommande0["refTarif"] = "1234"; // refTarif
	$ligneCommande0["codeTarif"] = "F-RW-MIGRATION"; // codeTarif associé au refTarif /* non obligatoire si refTarif renseigné

	$ligneCommande0["quantite"] = 1;
	// il faut activer la variable système CREATE_REGLEMENT_FOR_RIB_COMMANDE
	$ligneCommande0["modePaiement"] = 3; //3 Mandat (creation de Mandat necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
