<?php
	require_once("../resttbs.php");
	
	// Liste de suspensions	
	$refTitre = null; // reference du titre
	$codeClient = null; // code client
	$offset = null; // position du premier résultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 5 // par défaut le nombre maximum de résultat vaut 10
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Récupération des 5 premières suspensions : <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
	
	// Liste de suspensions	
	$refTitre = null; // reference du titre
	$codeClient = 58456; // code client
	$offset = 1; // position du premier résultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 10 // par défaut le nombre maximum de résultat vaut 10
	];
	
	$token = getToken(LOGIN,CREDENTIAL);
	print "<br><br>Récupération des suspensions pour le client : ".$codeClient."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
?>
