<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "33792"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	// $commandeDuclient["refMandat"] = 1111; // référence du mandat associé au client 
	// actuellement on n'a pas de WS pour la création de mandat donc pas possible de connaitre cette donnée :
	// solution temporaire : renseigné le bic/iban
	$commandeDuclient["bic"] = "BDFEFR2L"; 
	$commandeDuclient["iban"] = "FR7630001007941234567890185";
	
	$commandeDuclient["nePasModifierClient"] = 1; // permet de modifier les donnees client lors de la validation de la commande lorsque ca vaut 0

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();


	//Creation d'une ligne de commande d'abonnement
	
	// Soit refTarif soit codeTarif obligatoire
	// $ligneCommande0["refTarif"] = 4; // reference unique du tarif obtenu par l'api tarif
	$ligneCommande0["codeTarif"] = "F-RW-MIGRATION"; // codeTarif associé au refTarif

	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 3; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
