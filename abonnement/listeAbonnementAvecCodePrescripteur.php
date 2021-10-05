<?php
	require_once("../resttbs.php");
	

	$codePrescripteur = 12327015;

	// 2 cas de figure : 
	// soit on récupère uniquement tous les abonnements dont le codePrescripteur = $codePrescripteur
	// soit on récupère tous les abonnements dont le codePrescripteur = $codePrescripteur ou le codeClient = $codePrescripteur



	// 1er cas : Recupere tous les abonnements dont le codePrescripteur = $codePrescripteur  
	
	// la recherche sur le filtre : "codePrescripteur" 
	$filters = ["codePrescripteur.codeClient" => ["value" => $codePrescripteur, "matchMode" => "equals"]];
	
	$params = [
		"filters" => json_encode($filters), // obligatoire lorsque l'on veut rechercher sur le codePrescripteur uniquement 
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refAbonnement" // permet de filtrer sur la colonne refAbonnement
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "1er cas : Recupere tous les abonnements dont le codePrescripteur = ".$codePrescripteur." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/count", $token, $params);
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);



	// 2ieme cas : Recupere tous les abonnements dont le codePrescripteur = $codePrescripteur ou le codeClient = $codePrescripteur

	// Il faut passer directement par les parametres : "codeClient" = $codePrescripteur et "withSouscripteur" = 1
	$params = [
			"codeClient" => $codePrescripteur, // obligatoire lorsque l'on veut rechercher sur le codePrescripteur
			"withSouscripteur" => 1, // recherche sur le codePrescripteur ( = souscripteur)
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refAbonnement" // permet de filtrer sur la colonne refAbonnement
	];
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "2ieme cas : Recupere tous les abonnements dont le codePrescripteur ou le codeClient = ".$codePrescripteur." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/count", $token, $params);
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
	


?>