<?php
	require_once("../resttbs.php");
	
	// Recupere tous les clients créés depuis 00h00

	$dt = new DateTime();
	$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
	$dt->setTime(0, 0);
	$dt->setTimeZone(new DateTimeZone('UTC'));
	
	// Permet de récupérer les clients créé aujourd'hui
	$filters = ["creation" => ["value" => [$dt->format('Y-m-d\TH:i:s.\0\0\0'),""], "matchMode" => "range"]];
	
	$params = [
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "creation" // permet de filtrer sur la colonne creation
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere tous les clients créés depuis ".$filters["creation"]["value"][0]." a la date courante<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
?>