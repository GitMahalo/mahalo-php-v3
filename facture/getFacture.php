<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture
    $refFacture = 2497;
	
	// TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL, false);
	
	// Affichage des données de la facture au format json
	// Dans ce cas dans le Header de l'appel WS, il faut mettre : 'Accept: application/json'
	$response = callApiGet("/editeur/".REF_EDITEUR."/facture/".$refFacture, $token);
?>