<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Titre
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Nombre de titre<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/titre/count", $token);
	
	$params = [
			"maxResults" => 10
	];
	
	print "Lecture des 10 premiers titres<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/titre", $token, $params);

?>
