<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 1000;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des codes de selections du client ".$codeClient."<br>";
	$params = [
			"maxResults" => 1,
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/action", $token, $params);

?>
