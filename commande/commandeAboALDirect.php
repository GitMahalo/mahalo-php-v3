<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE
	
	// Création du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "100034"; //codeClient retourné par l'api client get (lecture) ou post (creation)
	$commandeDuclient["nom"] = "LE NOM"; //optionnel - informatif
	$commandeDuclient["prenom"] = "LE PRENOM"; //optionnel - informatif
	$commandeDuclient["email"] = "unemail@tbsblue.com"; //optionnel - informatif
	$commandeDuclient["portable"] = "0123456789"; //optionnel - informatif
	$commandeDuclient["noCommandeBoutique"] = "JHHU56UY"; //optionnel - votre numéro de commande boutique
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas écraser les données client lors de la validation de la commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();

	//Création d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 6; // référence unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande0["montantTtc"] = 48; //le montant n'a pas d'importance car il ne peut pas etre forcé dans le cadre d'un abonnement
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;

	//Création d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 51; // référence unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;  
	$ligneCommande1["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	$ligneCommande1["montantTtc"] = 12; //le montant peut ête forcé, attention donc à passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande1; 

	//Création d'une ligne de commande d'article libre
	$ligneCommande2["refTarif"] = 5; // référence unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;  
	$ligneCommande2["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande2["montantTtc"] = 12; //le montant peut ête forcé, attention donc à passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] = 0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande2;

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Réference de la commande = ".$response->value->noCommande."<br>";
	
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}
?>