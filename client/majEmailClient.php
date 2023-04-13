<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 10;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture du client à modifier codeClient = ".$codeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/".$codeClient, $token);

	if(property_exists($response, 'value') && $response->value !== null) {
		$client = $response->value;
		$client["email"] = 'email@test.com';
		
		print "Modification du client codeClient = ".$codeClient."<br>";
		$response = callApiPatch("/editeur/".REF_EDITEUR."/client/".$codeClient, $token, $client);
		
		print "codeClient du client modifié = ".$response->value->codeClient."<br><br>";
	}
?>
