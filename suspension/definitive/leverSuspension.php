<?php
	require_once("../../resttbs.php");
	
	// Lever une suspension
	$refAbonnement = 4; // reference abonnement
	$refMotifSuspension = 11; // reference motif suspension
	$numeroSuspension = null; // Numero de parution
	$dateSuspension = null; // Date de parution
	$reportDns = null; // Decalage de l'abonnement
	
	$params = [];
	
	$paramsQuery = [
			"refAbonnement" => $refAbonnement,// obligatoire
			"refMotifSuspension" => $refMotifSuspension,// obligatoire
			"numeroSuspension" => $numeroSuspension, // obligatoire
			"dateSuspension" => $dateSuspension, // obligatoire
			"reportDns" => $reportDns // obligatoire
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suspension du client : ".$codeClient."<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspension/lever", $token, $params, $paramsQuery);

?>
