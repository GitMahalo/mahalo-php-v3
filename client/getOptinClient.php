<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 11000;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des optins d'un client codeClient = ".$codeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/".$codeClient."/rgpd", $token);

?>
