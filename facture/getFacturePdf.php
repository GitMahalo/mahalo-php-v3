<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture
    $refFacture = 45727;
	
	// TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL, false);
	
	// Affichage du pdf de la facture
	// Dans ce cas dans le Header de l'appel WS, il faut mettre : 'Accept: application/pdf'
	$response = callApiGetTypePdf("/editeur/".REF_EDITEUR."/facture/".$refFacture, $token);
?>