<?php
	require_once("../resttbs.php");
	
	// Recupere la liste des modèles de doublon
	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere la liste des modèles de doublon<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/modeleDoublon", $token);
?>