<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE
	
	// Cr�ation du tampon client	
	$commandeDuclient = [];		
	$commandeDuclient["codeClient"] = 0000; //codeClient retourn� par l'api get client pour affecter la commande au client existant*
	$commandeDuclient["email"] = "email@email.fr";
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas �craser les donn�es adresse client
	$commandeDuclient["noCommandeBoutique"] = "CMDRHF"; //on peut passer ici une r�f�rence personnalis�e de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();
	
	//commande multilignes

	//Cr�ation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 10; // Reference interne du tarif d'abonnement obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande0["typeAdresseLiv"] =0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;

	//Cr�ation d'une ligne de commande d'article libre
	$ligneCommande0["refTarif"] = 11; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;  
	$ligneCommande1["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande1["montantTtc"] = 12; //le montant peut �te forc�, attention donc � passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] =0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande1;

	//Cr�ation d'une ligne de commande d'article libre
	$ligneCommande0["refTarif"] = 12; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;  
	$ligneCommande2["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)
	$ligneCommande2["montantTtc"] = 12; //le montant peut �te forc�, attention donc � passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] =0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande2;
	
	//TRAITEMENT DES CALL API
	
	print "Recuperation du token<br>";
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	
	print "<br><br>R�ference de la commande = ".$response->value->noCommande."<br>";
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
