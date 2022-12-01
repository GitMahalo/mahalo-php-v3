<?php
	require_once("../resttbs.php");
	header( 'content-type: text/html; charset= utf-8' );

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	$modePaiement = 'CB ABM';
	$refFacture = 544220;
	
	print "<b>Seul les factures one shot doivent être mis à jour via cet API !</b><br>";

	print "<b>Seul le mode de paiement $modePaiement doit être utilisé</b><br><br>";

	print "1- Récupération des infos de la facture à solder<br>";

	$params = [];
	$params["refFacture"] = $refFacture;

	$response = callApiGet("/editeur/".REF_EDITEUR."/reglement/buildParFacture", $token, $params);

	$reglement = $response->value;

	print "Vérification - Seules les factures dont le montant restant > 0 doivent être prise en compte.<br>";
	print "Montant restant à payer : $reglement->montantRegle<br>";

	if($reglement->montantRegle > 0) {
		print "2- Récupérer la référence du mode de paiement $modePaiement<br>";

		$params = [];
		$params["libelle"] = $modePaiement;
		$params["refSociete"] = $reglement->refSociete;

		$response = callApiGet("/editeur/".REF_EDITEUR."/modepaiement", $token, $params);

		if(count($response->value) == 1){

			$refModePaiement=$response->value[0]->refModePaiement;

			print "refModePaiement du moyen de paiement CB ABM : ".$refModePaiement."<br><br>";

			$dt = new DateTime();
			$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
			$dt->setTime(0, 0);

			//date du jour
			$reglement->dateReglement = $dt->format('Y-m-d');
			$reglement->refModePaiement = $refModePaiement;
			$reglement->modePaiement = $modePaiement;
			$reglement->typeReglement = 1;
			// $reglement->reactiverAbonnementsSuspendus = true;

			//création du réglement et solde de la facture
			$response = callApiPost("/editeur/".REF_EDITEUR."/reglement", $token, $reglement);

		}
	}
?>
