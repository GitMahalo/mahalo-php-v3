<?php
	require_once("../resttbs.php");
	
	// ACTIVATION D'UN MANDAT
	$refMandat = 134652;
	$codeClient = 753208;
	
	$params = [];		
	$params["refMandat"] = $refMandat; // refMandat Existante obtenu lors de la creation du mandat
	$params["codeClient"] = $codeClient; // codeClient concerne par le changement du mandat
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Activation du mandat $refMandat du client $codeClient<br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/mandat/activate", $token, null, $params);
	
	print "Reponse = ".$response->value."<br><br>";
?>
