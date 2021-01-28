<?php
	require_once("../resttbs.php");
	
	// Recupere les reglements du client 
	$filters = ["codeClient" => ["value" => 2023954, "matchMode" => "equals"]]; 
	
	$params = [
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refReglement" // permet de filtrer sur la colonne refReglement
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere les reglements du client ".$filters["codeClient"]["value"]."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/reglement", $token, $params);
	
?>