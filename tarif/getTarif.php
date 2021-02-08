<?php
	require_once("../resttbs.php");
	
	
	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);

	// Récupération du tarif en fonction de la refTarif
	$refTarif = 1;
	
	print "Lecture du tarif refTarif = ".$refTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/".$refTarif, $token);
	
?>