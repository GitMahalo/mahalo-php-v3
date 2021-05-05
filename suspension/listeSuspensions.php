<?php
	require_once("../resttbs.php");
	
	// Liste de suspensions	
	$refTitre = null; // reference du titre
	$codeClient = null; // code client
	$offset = null; // position du premier resultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 20 // OBLIGATOIRE le nombre maximum de resultat vaut 100
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Nombre totales suspensions : <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension/count", $token, $params);

	print "Recuperation des premieres suspensions : <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
	
	// Liste de suspensions	pour un codeClient donné
	$refTitre = null; // reference du titre
	$codeClient = 132445; // code client
	$offset = null; // position du premier resultat
	
	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 10 // OBLIGATOIRE le nombre maximum de resultat vaut 100
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Nombre totales suspensions pour le codeClient :".$codeClient." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension/count", $token, $params);

	print "<br><br>Recuperation des suspensions pour le client : ".$codeClient."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
		
	// Liste de suspensions	en fonction du type de motif
	$refTitre = null; // reference du titre
	$codeClient = null; // code client
	$offset = null; // position du premier resultat
	
	$refMotifSuspension = 2;
	$filters = ["refMotifSuspension" => ["value" => $refMotifSuspension, "matchMode" => "equals"]]; 

	$params = [
			"refTitre" => $refTitre, // non obligatoire
			"codeClient" => $codeClient,// non obligatoire
			"filters" => json_encode($filters), // non obligatoire
			"offset" => $offset,// non obligatoire 
			"maxResults" => 10 // OBLIGATOIRE le nombre maximum de resultat vaut 100
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Nombre totales suspensions dont la refMotifSuspension :".$refMotifSuspension." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension/count", $token, $params);

	print "Recuperation des premieres suspensions dont la refMotifSuspension :".$refMotifSuspension." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension", $token, $params);
?>
