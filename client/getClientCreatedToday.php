<?php
	require_once("../resttbs.php");
	
	// Recupere tous les clients créés depuis 00h00

	$dt = new DateTime();
	$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
	$dt->setTime(0, 0);
	$dt->setTimeZone(new DateTimeZone('UTC'));
	
	// Permet de récupérer les clients créé aujourd'hui depuis minuit
	$filters = ["c.creation" => ["value" => [$dt->format('Y-m-d\TH:i:s.\0\0\0'),""], "matchMode" => "range"]];
	
	$params = [
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "c.creation" // permet de filtrer sur la colonne creation
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere tous les clients créés depuis ".$filters["c.creation"]["value"][0]." a l'heure courante<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);

	
	$hier = new DateTime();
	$hier->setTimeZone(new DateTimeZone('Europe/Paris'));
	$hier->sub(new DateInterval('P1D'));
	$hier->setTime(0, 0);
	$hier->setTimeZone(new DateTimeZone('UTC'));

	$dt = new DateTime();
	$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
	$dt->setTime(0, 0);
	$dt->setTimeZone(new DateTimeZone('UTC'));

	// Permet de récupérer les clients créé aujourd'hui depuis minuit
	$filters = ["c.creation" => ["value" => [$hier->format('Y-m-d\TH:i:s.\0\0\0'),$dt->format('Y-m-d\TH:i:s.\0\0\0')], "matchMode" => "range"]];
	
	print "Recupere tous les clients créés depuis ".$filters["c.creation"]["value"][0]." a ".$filters["c.creation"]["value"][1]."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
?>