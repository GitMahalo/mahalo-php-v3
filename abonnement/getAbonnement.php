<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Abonnement
    $refAbonnement = 35276;
	
	// TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL, false);
	
	// Affichage du pdf de la abonnement
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/".$refAbonnement, $token);
?>