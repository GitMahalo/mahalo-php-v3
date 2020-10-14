<?php
	require_once("../resttbs.php");

	///////// COMMANDE SIMPLE PAIEMENT STRIPE ABONNEMENT ADL /////

	/*Apres retour STRIPE pour creation CB - envoyer le TOKEN a ABOWEB pour creation CB dans Aboweb*/
	/*le premier prelevement ne doit pas être execute par STRIPE mais par Aboweb. Stripe ne doit faiure qu'un empreinte de la CB */

	//PREPARATION DE LA CB

	$laCb=[];
	//Le prestaire de paiement CB est selectionne automatiquement en fonction du parametrage dans Aboweb
	$laCb["refSociete"] = REF_SOCIETE;
	$laCb["cbCode"] = "STR02";
	$laCb["token"] = "TEST_TOKEN01";//TOKEN retourne par Stripe lors de la capture de CB
	$laCb["dateVal"] = "1910";
	$laCb["number"] = "1664";

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient["codeClient"] = 000;  //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client (e utiliser uniquement si le codeClient est passe en parametre)
	$commandeDuclient["noCommandeBoutique"] = "HYIUN45IJ"; //on peut passer ici une reference personnalisee de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 12; // reference unique de l'abonnement ADL obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 6; //6 pour prelevement sur CB. La commande sera integree avec generation d'une facture non soldee et X prelevements en fonction des parametrages du tarif
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	print "Creation de la cb ".$laCb["cbCode"]."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $laCb);
	print "Reference interne de la CB = ".$response->value->refCb."<br>";
	$commandeDuclient["refCarteBancaire"] = $response->value->refCb;

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
