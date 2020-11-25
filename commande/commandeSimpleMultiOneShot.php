<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 2490964; //codeClient retourne par l'api get client pour affecter la commande au client existant*
	$commandeDuclient["email"] = "email@email.fr";
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client
	$commandeDuclient["noCommandeBoutique"] = "CMDRHF"; //on peut passer ici une reference personnalisee de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//commande multilignes

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 39370; // Reference interne du tarif d'abonnement obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] =0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 33521; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	// $ligneCommande1["montantTtc"] = 12; //le montant peut ete force, attention donc a passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] =0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande2["refTarif"] = 33526; // Reference interne du tarif d'article libre obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;
	$ligneCommande2["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	// $ligneCommande2["montantTtc"] = 12; //le montant peut ete force, attention donc a passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande2["typeAdresseLiv"] =0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande2;

	//TRAITEMENT DES CALL API

	print "Recuperation du token<br>";
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);

	print "<br><br>Reference de la commande = ".$response->value->noCommande."<br>";

	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
