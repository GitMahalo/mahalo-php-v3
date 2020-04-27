<?php
	require_once("../resttbs.php");

	///////// COMMANDE SIMPLE PAIEMENT STRIPE ABONNEMENT ADL /////

	/*Après retour STRIPE pour création CB - envoyer le TOKEN à ABOWEB pour création CB dans Aboweb*/
	/*le premier prélèvement ne doit pas Ãªtre éxécuté par STRIPE mais par Aboweb. Stripe ne doit faiure qu'un empreinte de la CB */

	//PREPARATION DE LA CB
	
	$laCb=[];
	//Le prestaire de paiement CB est selectionne automatiquement en fonction du parametrage dans Aboweb
	$laCb["refSociete"] = REF_SOCIETE;
	$laCb["cbCode"] = "STR02";
	$laCb["token"] = "TEST_TOKEN01";//TOKEN retourné par Stripe lors de la capture de CB
	$laCb["dateVal"] = "1910";
	$laCb["number"] = "1664";
	
	//PREPARATION DE LA COMMANDE
	
	// Création du tampon client			
	$commandeDuclient["codeClient"] = 000;  //codeClient retourné par l'api client get (lecture) si absent, le client sera créé lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas écraser les données adresse client (à utiliser uniquement si le codeClient est passé en paramètre)
	$commandeDuclient["noCommandeBoutique"] = "HYIUN45IJ"; //on peut passer ici une référence personnalisée de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();
		
	//Création d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 12; // référence unique de l'abonnement ADL obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 6; //6 pour prélèvement sur CB. La commande sera intégrée avec génération d'une facture non soldée et X prélèvements en fonction des paramétrages du tarif
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gérer d'adresse de livraison (l'adresse de livraison est gérée via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;
		
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Creation de la cb ".$laCb["cbCode"]."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $laCb);
	print "Réference interne de la CB = ".$response->value->refCb."<br>";
	$commandeDuclient["refCarteBancaire"] = $response->value->refCb;
	
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