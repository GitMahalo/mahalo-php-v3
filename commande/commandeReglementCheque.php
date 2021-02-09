<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 2171823; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client (a utiliser uniquement si le codeClient est passe en parametre)
	$commandeDuclient["noCommandeBoutique"] = 123456;
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement a reabonner 
	$ligneCommande0["refTarif"] = 39791; 
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$ligneCommande0["noCheque"] = "1234567"; // debut du numero de cheque
	
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	$ligneCommande = array();
	$ligneCommande[0] = $ligneCommande0;
	
	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";
	
?>