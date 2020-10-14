<?php
	require_once("../resttbs.php");
	
	// Suspension d'un abonnement	
	$refAbonnement = 4; // reference abonnement
	$refMotifSuspension = 11; // reference motif suspension
	$numeroSuspension = null; // Numéro de parution
	$dateSuspension = null; // Date de parution
	$reportDns = null; // Décalage de l’abonnement
	
	$params = [];
	
	$paramsQuery = [
			"refAbonnement" => $refAbonnement,// obligatoire
			"refMotifSuspension" => $refMotifSuspension,// obligatoire
			"numeroSuspension" => $numeroSuspension, // obligatoire
			"dateSuspension" => $dateSuspension, // obligatoire
			"reportDns" => $reportDns // obligatoire
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suspension d'un abonnement : ".$refAbonnement."<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspendre/abonnement", $token, $params, $paramsQuery);

?>
