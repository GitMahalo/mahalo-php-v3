<?php
	require_once("../resttbs.php");
	header( 'content-type: text/html; charset= utf-8' );
	
	//TRAITEMENT DES CALL API

	print "Création d'une offre d'abonnement simple et d'une formule en ADL en prel CB ou SEPA 1 prel par mois<br><br>";
	print "La formule contient une offre numérique unique<br><br>";
	print "ATTENTION nous contacter pour valider tout autre paramétrage<br><br><br>";

	$refTitreNumerique = 3;  // refTitre du support Numérique api titre pour le détail
	$montantTtc = 10;
	$refSociete = REF_SOCIETE;

	print "Support maitre numerique refTitre=$refTitreNumerique<br><br>";
	print "Montant de l'offre: $montantTtc<br><br>";

	$suffixTarifUnique = "";
	
	$token = getToken(LOGIN,CREDENTIAL);

	// Création d'un ABONNEMENT sur le titre numérique en prel en durée libre (ADL)
	$tarifAboDl = [];
	$tarifAboDl["refSociete"] = $refSociete; // Societe sur laquelle sera cree le tarif
	$tarifAboDl["codeTarif"] = 'T-N-1M-DL'.$suffixTarifUnique; // Tarif numerique 1 Mois en DL
	$tarifAboDl["desiTarif"] = 'Abonnement T-N-1M-DL'.$suffixTarifUnique; //designation de l'abonnement
	$tarifAboDl["typeTarif"] = 0; // si 0 et refTitre renseigne alors Abonnement
	$tarifAboDl["refTitre"] = $refTitreNumerique; //Obtenu par l'api titre
	$tarifAboDl["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAboDl["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par defaut
	$tarifAboDl["montantTtc"] = $montantTtc;
	$tarifAboDl["typeReglement"] = 8; //CB ou SEPA

	$tarifAboDl["servir"] = 1; //Nombre d'exemplaire a servir
	$tarifAboDl["tarifADL"] = true;
	$tarifAboDl["tarifPreleve"] = true;
	$tarifAboDl["nbPrelevements"] = 1;
	$tarifAboDl["frequencePrelevementUnite"] = 1; // 1 x prelevementTousLes (ici mois)
	$tarifAboDl["prelevementTousLes"] = 1; // Tous les mois
	$tarifAboDl["debutPrelevement"] = 1;
	$tarifAboDl["nbJoursDatePrel"] = 1;
	$tarifAboDl["invisible"] = "true"; // Les tarifs simples doivent etre en invisible et utilisé au sein de formule

	$tarifAboDl["familleTarif"] = "DL"; // Famille

	print "Creation  de l'offre Prel DL<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAboDl);

	//$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/160", $token);

	if(property_exists($response, 'value')) {
		print "refTarif de l'offre créée = ".$response->value->refTarif."<br><br>";

		$tarif1 = $response->value;

		//Création d'une formule avec l'abonnement de type DL

		$tarifFormule = [];
		$tarifFormule["refSociete"] = $refSociete; // Societe sur laquelle sera cree le tarif
		$tarifFormule["codeTarif"] = 'N-1M-DL'.$suffixTarifUnique; // Formule numerique 1 Mois en DL
		$tarifFormule["desiTarif"] = 'Formule N-1M-DL'.$suffixTarifUnique; //designation de la formule
		$tarifFormule["typeTarif"] = 1; // si 1 alors formule
		$tarifFormule["typeReglement"] = 8; //CB ou SEPA

		$tarifFormule["servir"] = 1; //Nombre d'exemplaire a servir
		$tarifFormule["tarifADL"] = true;
		$tarifFormule["tarifPreleve"] = true;
		$tarifFormule["nbPrelevements"] = 1;
		$tarifFormule["frequencePrelevementUnite"] = 1; // 1 x prelevementTousLes (ici mois)
		$tarifFormule["prelevementTousLes"] = 1; // Tous les mois
		$tarifFormule["debutPrelevement"] = 1;
		$tarifFormule["nbJoursDatePrel"] = 1;

		$tarifFormule["familleTarif"] = "DL"; // Famille

		//Constitution de la formule
		$tarifFormule["detailsFormule"] = [];

		$tarifFormule["detailsFormule"][] = $tarif1;
		//$tarifFormule["elements"][] = ["refTarif" => 12];
		$tarifFormule["montantTtc"] = 0;
		//Somme des montants de la formule
		foreach($tarifFormule["detailsFormule"] as $t) {
			$tarifFormule["montantTtc"] += $t->montantTtc;
		}

		print_r($tarifFormule);

		print "Creation de l'offre Formule Prel DL<br>";
		$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifFormule);

		if(property_exists($response, 'value')) {
			print "refTarif de l'offre créée = ".$response->value->refTarif."<br><br>";
		}
	}
?>
