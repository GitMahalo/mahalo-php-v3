<?php
	require_once("../resttbs.php");

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Seul les factures one shot doivent être mis à jour via cet API !";

	print "Seul le mode de paiement CB ABM doit être utilisé";

	print "1- Récupération des infos de la facture à solder";

	$params = [];
	$params["refFacture"] = 91561;

	$response = callApiGet("/editeur/".REF_EDITEUR."/reglement/buildParFacture", $token, $params);

	$reglement = $response->value;

	print "Vérification - Seules les factures dont le montant restant > 0 doivent être prise en compte : $reglement->montantRegle";
	if($reglement->montantRegle > 0) {
		print "2- Récupérer la référence du mode de paiement CB ABM";

		$params = [];
		$params["libelle"] = 'CB ABM';
		$params["refSociete"] = 1; //reference de la societe qui facture

		$response = callApiGet("/editeur/".REF_EDITEUR."/modepaiement", $token, $params);

		$refModePaiement=$response->value->refModePaiement;

		print "refModePaiement du moyen de paiement CB ABM : ".$refModePaiement."<br><br>";

		$dt = new DateTime();
		$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
		$dt->setTime(0, 0);

		//date du jour
		$reglement->dateReglement = $dt->format('Y-m-d');
		$reglement->refModePaiement = $refModePaiement;

		//création du réglement et solde de la facture
		$response = callApiPost("/editeur/".REF_EDITEUR."/reglement", $token, $reglement);
	}
?>
