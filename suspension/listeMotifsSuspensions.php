<?php
	require_once("../resttbs.php");
	
	// Liste des motifs de suspensions	
	
	$params = [];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "R�cup�ration des motifs de suspensions : <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/suspension/motifs", $token, $params);
?>
