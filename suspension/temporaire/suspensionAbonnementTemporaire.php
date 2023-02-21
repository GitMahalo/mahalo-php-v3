<?php
	require_once("../../resttbs.php");
	header( 'content-type: text/html; charset= utf-8' );

	//Parametres obligatoires
	$refAbonnement = 325202; // reference d'un des abonnements du client à suspendre
	$dateDebut = new DateTime("2020-08-05",new DateTimeZone('Europe/Paris')); // date de debut de la suspension
	$dateFin = new DateTime("2020-09-03",new DateTimeZone('Europe/Paris')); // date de fin de la suspension
	$refMotifSuspension = 11; // reference motif suspension
	
	print "<h1>Suspensions temporaires</h1>";
	print "<h2>Fonctionnement des suspensions temporaires</h1>";
	print "<p>Attention les suspensions temporaires contrairement à la suspension définitive doivent se faire sur tous les abonnements d'une formule d'un client</p>";
	print "<p>La fonction prend une liste d'abonnements (tous les abonnements de la formule) qui serviront de base à la fonction</p>";
	print "<p>Le traitement effectif est le suivant : à partir des supports distincts issus de la liste des abonnements, on suspendra tous les abonnements de ces supports trouvés sur la période pour le client.</p>";
	
	print "<h2>Etapes</h2>";

	print "<ol>
		<li>Récupération d'un des abonnements du client</li>
		<li>Récupération des abonnements d'une formule</li>
		<li>Suspension temporaire des abonnements de la formule</li>
	</ol>";

	print "<h2>Exemple</h2>";
	$token = getToken(LOGIN,CREDENTIAL);

	$listAbos = [];
	print "Recuperation de l'abonnement ".$refAbonnement." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/".$refAbonnement, $token);
	if (property_exists($response, 'value')) {
		$abonnement = $response->value;
		if($abonnement){
			//Recuperation de tous les abonnements de la meme formule
			$filters = ["sequenceFormule" => ["value" => $abonnement->sequenceFormule, "matchMode" => "equals"]]; 
		
			$params = [
					"maxResults" => 50, // champs obligatoire compris entre 1 et 100
					"filters" => json_encode($filters)
			];
			
			//TRAITEMENT DES CALL API
			
			print "Recuperation de tous les abonnements de la formule de l'abonnement ".$refAbonnement." <br><br>";
			$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
			if (property_exists($response, 'value')) {
				$abonnements = $response->value;
				foreach($abonnements as $abonnement){
					$listAbos[] = $abonnement->refAbonnement;
				}
			}
		}
	}

	print count($listAbos)." abonnements a suspendre<br><br>";
	if(count($listAbos) > 0){
		// Suspension temporaire des abonnements de la formule
		$dateDebut->setTimezone(new DateTimeZone("UTC"));
		$dateFin->setTimezone(new DateTimeZone("UTC"));

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

		print "Suspension temporaire des abonnements<br><br>";
		$response = callApiPost("/editeur/".REF_EDITEUR."/suspension", $token, $params); //, $paramsQuery);
	}
?>
