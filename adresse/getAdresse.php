<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$refAdresse = 81494;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture de l'adresse = ".$refAdresse."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/adresse/".$refAdresse, $token);

?>
