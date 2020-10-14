<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL refTitre =  3 
	
	$filters = ["refTitre" => ["value" => 3, "matchMode" => "equals"]]; // "matchMode" permet de filtrer sur une donnée de facon strict ou non ("equals"/"contains"/"startsWith") 
	
	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters)
			
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des tarifs du titre = ".$filters["refTitre"]["value"]."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	
	
	//LECTURE DU REFERENTIEL refTitre =  3 avec un classement par ref_tarif
	
	$filters = ["refTitre" => ["value" => 3, "matchMode" => "equals"]]; // "matchMode" permet de filtrer sur une donnée de facon strict ou non ("equals"/"contains"/"startsWith") 
	
	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou décroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
			
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des tarifs du titre = ".$filters["refTitre"]["value"]." avec tri sur la refTarif <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	
		
	//LECTURE DU REFERENTIEL pour recupere les tarifs ayant pour origine de reabonnement WEB et en triant par refTarif
	
	$filters = ["pc2.paramCs1.refCs" => ["value" => 506, "matchMode" => "equals"],
				"libelleCs2" => ["value" => "ACTAACJB", "matchMode" => "equals"]]; 
	
	$params = [
			"maxResults" => 50, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou décroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
			
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des tarifs pour l'origine = ".$filters["libelleCs2"]["value"]." avec tri sur la refTarif <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
?>