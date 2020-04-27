<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL tva
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des codes de tva<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tva/list/code", $token);

?>
