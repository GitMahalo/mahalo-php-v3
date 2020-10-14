<?php
	require_once("../../resttbs.php");
	
	// Suspension temporaire d'un abonnement
	$refAbonnement = 12905; // reference abonnement
	$dateDebut = new DateTime("2020-08-05",new DateTimeZone('Europe/Paris')); // date de debut de la suspension
	$dateDebut->setTimezone(new DateTimeZone("UTC"));
	$dateFin = new DateTime("2020-09-03",new DateTimeZone('Europe/Paris')); // date de fin de la suspension
	$dateFin->setTimezone(new DateTimeZone("UTC"));	
	$refMotifSuspension = 11; // reference motif suspension
	
	//Liste des abos à suspendre
	$listAbos = [];
	$listAbos[] = $refAbonnement;
	
	//Information sur la suspension
	$suspension = [
		"codeMotifSuspension" => $refMotifSuspension,
		"dateDebut" => $dateDebut->format('Y-m-d\TH:i:s.\0\0\0'),
		"dateFin" => $dateFin->format('Y-m-d\TH:i:s.\0\0\0')
	];
	
	$params = [
			"abonnements" => $listAbos,// obligatoire
			"suspension" => $suspension,// obligatoire 
		];
	
	// $paramsQuery = [];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suspension temporaire d'un abonnement : ".$refAbonnement."<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/suspension", $token, $params); //, $paramsQuery);

?>
