<?php
	require_once("../resttbs.php");
	
	//LECTURE DU MODE DE PAIEMENT
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
		"refSociete" => 1, // champs obligatoire
		"typeReglement" => 7 // champs optionnel
	];

	print "Lecture des modes de paiement <br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/modepaiement", $token, $params);

?>
