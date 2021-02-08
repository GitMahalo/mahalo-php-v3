<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 2023969;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
		"codeClient" => $codeClient, // OBLIGATOIRE
		"maxResults" => 10// OBLIGATOIRE
	];

	print "Lecture des adresses non principales du client codeClient = ".$codeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/adresse", $token, $params);

?>
