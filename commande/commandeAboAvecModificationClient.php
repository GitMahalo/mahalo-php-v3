<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "5019007"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	
	$commandeDuclient["nePasModifierClient"] = 0; // permet de modifier les donnees client lors de la validation de la commande lorsque ca vaut 0

	// Dans le cas où "nePasModifierClient" = 0
	// Alors les champs adresse ci-dessous sont obligatoire en cas de 
	// modification de donnée et pour ne pas perdre la donnée déjà existante
	$commandeDuclient["civilite"] = "M ou Mme"; 
	$commandeDuclient["nom"] = "LE NOM"; 
	$commandeDuclient["prenom"] = "LE PRENOM"; 
	$commandeDuclient["societe"] = "SOCIETE"; 
	$commandeDuclient["titreAdresse"] = "TITRE ADRESSE"; 
	$commandeDuclient["adresse1"] = "ADRESSE 1"; 
	$commandeDuclient["adresse2"] = "ADRESSE 2"; 
	$commandeDuclient["adresse3"] = "ADRESSE 3"; 
	$commandeDuclient["adresse4"] = "ADRESSE 4"; 
	$commandeDuclient["cp"] = "12345"; 
	$commandeDuclient["ville"] = "VILLE"; 
	$commandeDuclient["email"] = "unemail@tbsblue.com"; 
	$commandeDuclient["telephone"] = "0101010101";
	$commandeDuclient["telecopie"] = "0123456789";
	$commandeDuclient["portable"] = "0123456789";
	$commandeDuclient["codeIso"] = "FR";
	$commandeDuclient["codePays"] = "XXXXX";
	$commandeDuclient["nomPays"] = "FRANCE";
	$commandeDuclient["pays"] = "FRANCE";
	$commandeDuclient["codeNii"] = "CODE NII";

	$commandeDuclient["noCommandeBoutique"] = "JHHU56UY";

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["montantTtc"] = 48; //le montant n'a pas d'importance car il ne peut pas etre force dans le cadre d'un abonnement
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 51; // reference unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	$ligneCommande1["montantTtc"] = 12; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande2["refTarif"] = 5; // reference unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;
	$ligneCommande2["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande2["montantTtc"] = 12; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande2;

	$leCsClient0 = [];
	$leCsClient0["refCs"] = 1011; //Reference du parametre CS obtenu par l'api aidesaisie (champ refCs)
	$leCsClient0["libelle"] = "INFOCSCLIENT0";

	$leCsClient1 = [];
	$leCsClient1["refCs"] = 1006; //Reference du parametre CS obtenu par l'api aidesaisie (champ refCs)
	$leCsClient1["libelle"] = "123456";

	$leCsAbonnement = [];
	$leCsAbonnement["refCs"] = 1008;
	$leCsAbonnement["libelle"] = "UNCSABO";

	$leCsFacture = [];
	$leCsFacture["refCs"] = 1009;
	$leCsFacture["libelle"] = "UNSCFACTURE";

	$leCsLigneFacture = [];
	$leCsLigneFacture["refCs"] = 1010;
	$leCsLigneFacture["libelle"] = "UNCSLIGNEFACTURE";

	//ajout des code de selection qui seront rattaches au futur client sur la structure tamponClient
	$codesSelection = [];
	$codesSelection[] = $leCsClient0; //ajout d'un CS sur client
	$codesSelection[] = $leCsClient1; //ajout d'un autre CS sur client
	$codesSelection[] = $leCsFacture; //ajout d'un CS sur la facture du client
	$commandeDuclient["codesSelection"] = $codesSelection;

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
