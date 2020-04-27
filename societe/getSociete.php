<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Societe
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 10
	];
	
	print "Lecture des societes<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/societe", $token);

?>
