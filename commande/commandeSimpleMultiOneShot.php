<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE
	
	// Création du tampon client	
	$commandeDuclient = [];		
	$commandeDuclient["codeClient"] = 0000; //codeClient retourné par l'api get client pour affecter la commande au client existant*
	$commandeDuclient["email"] = "email@email.fr";
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas écraser les données adresse client
	$commandeDuclient["noCommandeBoutique"] = "CMDRHF"; //on peut passer ici une référence personnalisée de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();
	
	//commande multilignes

	//Création d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 10; // Reference interne du tarif d'abonnement obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande0["typeAdresseLiv"] =0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;

	//Création d'une ligne de commande d'article libre
	$ligneCommande0["refTarif"] = 11; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;  
	$ligneCommande1["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande1["montantTtc"] = 12; //le montant peut ête forcé, attention donc à passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] =0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande1;

	//Création d'une ligne de commande d'article libre
	$ligneCommande0["refTarif"] = 12; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;  
	$ligneCommande2["modePaiement"] = 2; //1 chèque - 2 CB - 3 RIB (création de Mandat nécessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (création de CB nécessaire en amont)
	$ligneCommande2["montantTtc"] = 12; //le montant peut ête forcé, attention donc à passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] =0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande2;
	
	//TRAITEMENT DES CALL API
	
	print "Recuperation du token<br>";
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	
	print "<br><br>Réference de la commande = ".$response->value->noCommande."<br>";
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
