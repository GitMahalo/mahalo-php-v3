<?php
	require_once("../resttbs.php");

	///////// COMMANDE SIMPLE PAIEMENT STRIPE ABONNEMENT ADL /////

	/*Apres retour STRIPE pour creation CB - envoyer le TOKEN a ABOWEB pour creation CB dans Aboweb*/
	/*le premier prelevement ne doit pas être execute par STRIPE mais par Aboweb. Stripe ne doit faire qu'une empreinte de la CB */

	//Le prestaire de paiement CB est selectionne automatiquement en fonction du parametrage dans Aboweb
	
	// CREATION D'UNE CARTE BANCAIRE	
	$laCb=[];
	$laCb["token"] = 'SMLLwsqPLdt'; // token
	// $laCb["cbCode"] = null; // pour une creation cb 
	$laCb["dateVal"] = '2109'; // date d'expiration de la cb au format 'yyMM'
	$laCb["firstNumbers"] = 1234; // premiers chiffres d'une cb
	$laCb["lastNumbers"] = 9876; // derniers chiffres d'une cb
	$laCb["titulaire"] = 'NOM PRENOM'; // nom prenom du titulaire de la cb
	$laCb["refPrestataire"] = 1; // reference du prestataire de paiement (la valeur refPrestataire est à adapter selon l'editeur)

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
	//$ligneCommande0["modePaiement"] = 2; //2 pour un prelevement sur CB pour lequel la première occurence de paiement est faite à la commande, coté site
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

