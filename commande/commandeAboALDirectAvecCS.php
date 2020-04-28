<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE
	
	// Cr�ation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "100034"; //codeClient retourn� par l'api client get (lecture) ou post (creation)
	$commandeDuclient["nom"] = "LE NOM"; //optionnel - informatif
	$commandeDuclient["prenom"] = "LE PRENOM"; //optionnel - informatif
	$commandeDuclient["email"] = "unemail@tbsblue.com"; //optionnel - informatif
	$commandeDuclient["portable"] = "0123456789"; //optionnel - informatif
	$commandeDuclient["noCommandeBoutique"] = "JHHU56UY"; //optionnel - votre num�ro de commande boutique
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas �craser les donn�es client lors de la validation de la commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();

	//Cr�ation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // r�f�rence unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande0["montantTtc"] = 48; //le montant n'a pas d'importance car il ne peut pas etre forc� dans le cadre d'un abonnement
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;

	//Cr�ation d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 51; // r�f�rence unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;  
	$ligneCommande1["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	$ligneCommande1["montantTtc"] = 12; //le montant peut �te forc�, attention donc � passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande1; 

	//Cr�ation d'une ligne de commande d'article libre
	$ligneCommande2["refTarif"] = 5; // r�f�rence unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;  
	$ligneCommande2["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande2["montantTtc"] = 12; //le montant peut �te forc�, attention donc � passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande2;

	


	$leCsClient0 = [];
	$leCsClient0["refCs"] = 1011; //R�f�rence du param�tre CS obtenu par l'api aidesaisie (champ refCs)
	$leCsClient0["libelle"] = "INFOCSCLIENT0";
	
	$leCsClient1 = [];
	$leCsClient1["refCs"] = 1006; //R�f�rence du param�tre CS obtenu par l'api aidesaisie (champ refCs)
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

	// Cr�ation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 0; //codeClient retourn� par l'api client get (lecture) ou post (creation)
	$commandeDuclient["nom"] = "LE NOM"; //optionnel - informatif
	$commandeDuclient["prenom"] = "LE PRENOM"; //optionnel - informatif
	$commandeDuclient["email"] = "unemail@tbsblue.com"; //optionnel - informatif
	$commandeDuclient["codeIsoPays"] = "FR"; //optionnel - informatif
	$commandeDuclient["portable"] = "0123456789"; //optionnel - informatif
	$commandeDuclient["codeClientTransco"] = "1234HG"; //optionnel - informatif
	$commandeDuclient["nePasModifierClient"] = 0; //permet de ne pas �craser les donn�es client lors de la validation de la commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = [];
	
	//ajout des code de s�lection qui seront rattach�s au futur client sur la structure tamponClient
	$codesSelection = [];
	$codesSelection[] = $leCsClient0; //ajout d'un CS sur client
	$codesSelection[] = $leCsClient1; //ajout d'un autre CS sur client
	$codesSelection[] = $leCsFacture; //ajout d'un CS sur la facture du client
	$commandeDuclient["codesSelection"] = $codesSelection;
	
	//Cr�ation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // r�f�rence unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande0["montantTtc"] = 48; //le montant n'a pas d'importance car il ne peut pas etre forc� dans le cadre d'un abonnement
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$ligneCommande0["codesSelection"] = [];
	$ligneCommande0["codesSelection"][] = $leCsAbonnement; //CS sur l'abonnement
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;
	
	//Cr�ation d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 51; // r�f�rence unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	$ligneCommande1["montantTtc"] = 12; //le montant peut �te forc�, attention donc � passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	
	$ligneCommande1["codesSelection"] = [];
	$ligneCommande1["codesSelection"][] = $leCsLigneFacture; //CS sur la ligne de facture
	$commandeDuclient["ligneCommande"][] = $ligneCommande1;
		
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "R�ference de la commande = ".$response->value->noCommande."<br>";
	
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
