<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "4886051"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees client lors de la validation de la commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	// Exemple d'ajout de codes de selection (= CS) sur le client, abonnement, facture et ligne facture
	// les CS du client et de la facture sont liés à la commande du client
	// les CS de l'abonnement et de la ligne facture sont liés à la ligne de commande
	// RefCs = Reference du parametre CS obtenu par l'api aidesaisie (champ refCs)
	// libelle = donnée du CS mise au format 'string'
	// Remarque : les CS sur le client ne fonctionnent que dans le cas où on vient d'aboshop donc ici je les mets en commentaire

	// CS sur le client et la facture a la commande du client
	// CS pour le client
	// $leCsClient0 = [];
	// $leCsClient0["refCs"] = 1011; 
	// $leCsClient0["libelle"] = "3EME";
	
	// $leCsClient1 = [];
	// $leCsClient1["refCs"] = 1005; 
	// $leCsClient1["libelle"] = "Masculin";
	
	// $leCsClient2 = [];
	// $leCsClient2["refCs"] = 1010; 
	// $leCsClient2["libelle"] = "TRUE";
	
	// CS pour la facture
	$leCsFacture1 = [];
	$leCsFacture1["refCs"] = 1019;
	$leCsFacture1["libelle"] = "TRUE";
	// FIN CS sur le client et la facture a la commande du client
	
	// CS de l'abonnement et de la ligne facture liés à la ligne de commande
	// CS pour l'abonnement
	$leCsAbonnement = [];
	$leCsAbonnement["refCs"] = 1020;
	$leCsAbonnement["libelle"] = "TRUE";

	// CS pour les lignes factures
	$leCsLigneFacture = [];
	$leCsLigneFacture["refCs"] = 1021;
	$leCsLigneFacture["libelle"] = "TRUE";
	// FIN CS de l'abonnement et de la ligne facture liés à la ligne de commande

	// ajout des CS qui seront rattaches au futur client sur la structure tamponClient
	// $codesSelectionTamponClient[] = $leCsClient0; //ajout d'un CS sur client
	// $codesSelectionTamponClient[] = $leCsClient1; //ajout d'un CS sur client
	// $codesSelectionTamponClient[] = $leCsClient2; //ajout d'un CS sur client
	$codesSelectionTamponClient[] = $leCsFacture1; //ajout d'un CS sur la ligne facture
	$commandeDuclient["codesSelection"] = $codesSelectionTamponClient;
	
	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	// ajout des CS qui seront rattaches au futur client sur la structure tamponCommande
	$codesSelectionTamponCommande[] = $leCsAbonnement; // ajout d'un CS sur l'abonnement
	$codesSelectionTamponCommande[] = $leCsLigneFacture; // ajout d'un CS sur la facture
	$ligneCommande0["codesSelection"] = $codesSelectionTamponCommande;

	$commandeDuclient["lignesCommande"][] = $ligneCommande0;
	
	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
