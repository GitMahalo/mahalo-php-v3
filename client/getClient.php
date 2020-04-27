<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 10;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture du client codeClient = ".$codeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/".$codeClient, $token);

?>
