<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "2001713"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	
	// 0 : permet de modifier les donnees client lors de la validation de la commande 
	// Alors les champs adresse ci-dessous sont obligatoire en cas de 
	// modification de donnée et pour ne pas perdre la donnée déjà existante
	// 1 : ne modifie pas les donnees du client lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; 

	
	$commandeDuclient["nom"] = "LE NOM"; 
	$commandeDuclient["prenom"] = "LE PRENOM"; 
	// $commandeDuclient["societe"] = "SOCIETE"; 
	// $commandeDuclient["titreAdresse"] = "TITRE ADRESSE"; 
	// $commandeDuclient["adresse1"] = "ADRESSE 1"; 
	// $commandeDuclient["adresse2"] = "ADRESSE 2"; 
	// $commandeDuclient["adresse3"] = "ADRESSE 3"; 
	// $commandeDuclient["adresse4"] = "ADRESSE 4"; 
	// $commandeDuclient["cp"] = "12345"; 
	$commandeDuclient["ville"] = "VILLE"; 
	$commandeDuclient["email"] = "unemail@tbsblue.com"; 
	$commandeDuclient["telephone"] = "0101010101";
	// $commandeDuclient["telecopie"] = "0123456789";
	// $commandeDuclient["portable"] = "0123456789";
	// $commandeDuclient["codeIso"] = "FR";
	// $commandeDuclient["codePays"] = "XXXXX";
	// $commandeDuclient["nomPays"] = "FRANCE";
	// $commandeDuclient["pays"] = "FRANCE";
	// $commandeDuclient["codeNii"] = "CODE NII";

	// $commandeDuclient["noCommandeBoutique"] = "JHHU56UY";

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'une formule ''
	$ligneCommande0["refTarif"] = 474; // reference unique d'une formule /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	//$ligneCommande0["montantTtc"] = 7; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;
	
	//Creation d'une ligne de commande d'une formule ''
	$ligneCommande0BIS["refTarif"] = 474; // reference unique d'une formule /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0BIS["quantite"] = 1;
	$ligneCommande0BIS["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	//$ligneCommande0BIS["montantTtc"] = 7; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande0BIS["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0BIS;

	//Creation d'une ligne de commande d'une formule
	$ligneCommande1["refTarif"] = 10; // reference unique d'une formule /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	// $ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	//$ligneCommande1["montantTtc"] = 39; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande2["refTarif"] = 32; // reference unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;
	$ligneCommande2["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	//$ligneCommande2["montantTtc"] = 12.90; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande2;

	$leCsClient0 = [];
	$leCsClient0["refCs"] = 1002; //Reference du parametre CS 'CODE DOUBLON' obtenu par l'api aidesaisie (champ refCs)
	$leCsClient0["libelle"] = 123456;

	//ajout des codes de selection qui seront rattaches au client sur la structure tamponClient
	$codesSelection = [];
	$codesSelection[] = $leCsClient0; //ajout d'un CS sur client
	$commandeDuclient["codesSelection"] = $codesSelection;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
