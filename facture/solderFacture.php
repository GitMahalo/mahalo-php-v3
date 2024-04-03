<?php
	require_once("../resttbs.php");
	header( 'content-type: text/html; charset= utf-8' );

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	$modePaiement = 'CB ABM';
	$refFacture = 2027553;
	$reactiverAbonnementsSupsendus = true;
	
	print "<b>Seul les factures one shot ou en 1 prel de type ADL doivent être mises à jour via ce scénario !</b><br>";

	print "<b>Le paiement one shot doit être réalisée par l'appelant du montant de la facture avant exécution de ce scénario !</b><br>";

	if($reactiverAbonnementsSupsendus) {
		print "<b>Ce script réactivera les abonnements </b><br>";
	} else {
		print "<b>Ce script ne réactivera pas les abonnements </b><br>";
	}

	print "<b>Seul le mode de paiement $modePaiement doit être utilisé</b><br><br>";

	print "1- Récupération des infos de la facture à solder<br>";

	$params = [];
	$params["refFacture"] = $refFacture;

	$response = callApiGet("/editeur/".REF_EDITEUR."/reglement/buildParFacture", $token, $params);

	$reglement = $response->value;

	print "Vérification - Seules les factures dont le montant restant > 0 doivent être prise en compte.<br>";
	print "Montant restant à payer : $reglement->montantRegle<br>";

	if(!($reglement->typeReglement == 1 ||  $reglement->typeReglement == 6)) {
		print "Erreur - le type de reglement n'est pas eligible : " . $reglement->typeReglement;
		exit;
	}

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

			$paramsQuery = [
				"reactiverAbonnementsSuspendus" => $reactiverAbonnementsSupsendus
			];

			//création du réglement et solde de la facture
			$response = callApiPost("/editeur/".REF_EDITEUR."/reglement", $token, $reglement, $paramsQuery);

		}
	} else {
		print "Erreur - la facture #" . $refFacture . " est deja soldée ";
	}
?>
