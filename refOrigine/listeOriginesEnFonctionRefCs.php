<?php
	require_once("../resttbs.php");
	
	// Recupere la liste liées à une origine

	$refCs1 = 500; // 500 pour l'origine abonnement / 506 pour l'origine de reabonnement
	$refSociete = 1;
	$keyword = "";
	
	$params = [
			"cs1ID" => $refCs1, // OBLIGATOIRE 500 pour l'origine abonnement / 506 pour l'origine de reabonnement
			"refSociete" => $refSociete, // OBLIGATOIRE 
			// "keyword" => $keyword // OPTIONNEL 
	];
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere la liste liées à une origine<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/reforigine", $token, $params);

?>