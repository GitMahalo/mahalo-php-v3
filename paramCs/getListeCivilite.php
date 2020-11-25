<?php
	require_once("../resttbs.php");
	
	// Recupere les civilités en fonction de la refCs1 = 9

	$refCs1 = 9; // 9 <=> correspond à la liste des civilités
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere le paramCs2 en fonction de la refCs1 = ".$refCs1."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/cs2/".$refCs1, $token);
	
?>