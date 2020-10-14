<?php
	require_once("../resttbs.php");
	
	// ACTIVATION D'UNE CARTE BANCAIRE
	$refCb = 18;
	$codeClient = 1524521;
	
	$params = [];		
	$params["refCb"] = $refCb; // refCb Existante obtenu lors de la creation de la cb
	$params["codeClient"] = $codeClient; // codeClient concerne par le changement de cb
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Activation de la carte bancaire $refCb du client $codeClient<br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire/activate", $token, $params);
	
	print "Reponse = ".$response->value."<br><br>";
?>
