<?php
	require_once("../resttbs.php");
	
	// Liste de suspensions	
	$refTitre = null; // reference du titre
	$codeClient = null; // code client
	$offset = null; // position du premier r�sultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 5 // par d�faut le nombre maximum de r�sultat vaut 10
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "R�cup�ration des 5 premi�res suspensions : <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
	
	// Liste de suspensions	
	$refTitre = null; // reference du titre
	$codeClient = 58456; // code client
	$offset = 1; // position du premier r�sultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 10 // par d�faut le nombre maximum de r�sultat vaut 10
	];
	
	$token = getToken(LOGIN,CREDENTIAL);
	print "<br><br>R�cup�ration des suspensions pour le client : ".$codeClient."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
?>
