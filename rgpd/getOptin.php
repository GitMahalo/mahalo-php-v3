<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Optin
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 10,
			"offset" => 0
	];

	print "Nombre d'optin dans le referentiel<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/rgpd/count", $token, $params);
	
	print "Liste des optins<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/rgpd/liste", $token, $params);

?>
