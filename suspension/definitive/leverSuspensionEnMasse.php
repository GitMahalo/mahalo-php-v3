<?php
	require_once("../resttbs.php");
	
	// Lever une suspension sur plusieurs abonnements
	$listeRefAbonnement = [];
	$refMotifSuspension = 228; // reference motif suspension
	$numeroSuspension = null; // Numéro de parution
	$dateSuspension = null; // Date de parution
	$reportDns = null; // Décalage de l’abonnement
	
	foreach ($listeRefAbonnement as $refAbonnement){
	
		$params = [];
		
		$paramsQuery = [
				"refAbonnement" => $refAbonnement,// obligatoire
				"refMotifSuspension" => $refMotifSuspension,// obligatoire
				"numeroSuspension" => $numeroSuspension,
				"dateSuspension" => $dateSuspension,
				"reportDns" => $reportDns
		];
		
		$token = getToken(LOGIN,CREDENTIAL);
	
		print "Suspension du client : ".$codeClient."<br><br>";
		$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspension/lever", $token, $params, $paramsQuery);
	}

?>
