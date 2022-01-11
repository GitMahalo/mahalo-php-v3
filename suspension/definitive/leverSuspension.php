<?php
	require_once("../../resttbs.php");
	
	// Leve toute ou partie des suspensions sur un abonnement
	$refAbonnement = 4; // reference abonnement
	$numeroSuspension = null; // Leve toutes les suspensions jusqu'à ce numéro
	$dateSuspension = null; // Leve toutes les suspensions jusqu'à cette date
	$reportDns = false; // Decalage de l'abonnement (true ou false
	
	$params = [];
	
	$paramsQuery = [
			"refAbonnement" => $refAbonnement,// obligatoire
			"numeroSuspension" => $numeroSuspension,
			"dateSuspension" => $dateSuspension,
			"reportDns" => $reportDns
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suspension du client : ".$codeClient."<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspension/lever", $token, $params, $paramsQuery);

?>
