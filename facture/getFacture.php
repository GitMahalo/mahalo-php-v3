<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture
    $refFacture = 2497;
	
	// TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL, false);
	
	// Affichage du pdf de la facture
	$response = callApiGet("/editeur/".REF_EDITEUR."/facture/".$refFacture, $token);
?>