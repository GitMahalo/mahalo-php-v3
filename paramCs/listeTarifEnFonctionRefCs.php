<?php
	require_once("../resttbs.php");
	
	// Recupere le paramCs2 en fonction de la refCs1 et du code origine 

	$refCs1 = 500;
	$codeCs = "ACTAACJC";
	
	$params = [
			"refCs1" => $refCs1, // 500 pour l'origine abonnement / 506 pour l'origine réabonnement
			"codeCs" => $codeCs // codeCs qu'on retrouve dans le code_relance de l'abonnement
	];
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere le paramCs2 en fonction de la refCs1 = ".$refCs1." et du code origine ".$codeCs." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/cs2", $token, $params);
	
	// Recupere tous les tarifs lies a l'origine 

	$refCs = 754798;
	$params = [
			"typeTarif" => 1 // 1 pour les formules 0 pour les abonnements simples
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere tous les tarifs lies a l'origine ".$refCs." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/cs2/".$refCs."/tarif", $token, $params);
	
?>