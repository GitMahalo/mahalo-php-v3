<?php
	require_once("../resttbs.php");
	

	$codePrescripteur = 12327015;

	// Recupere tous les abonnements dont le codePrescripteur = $codePrescripteur ou le codeClient = $codePrescripteur 
	
	// ATTENTION : actuellement, la recherche sur le filtre : "codePrescripteur" ne fonctionne pas. 
	// $filters = ["codePrescripteur" => ["value" => $codePrescripteur, "matchMode" => "equals"]]; // Erreur technique dans ce cas.

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
	
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/count", $token, $params);

	print "Recupere tous les abonnements dont le codePrescripteur ou le codeClient = ".$codePrescripteur." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
	
?>