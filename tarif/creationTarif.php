<?php
	require_once("../resttbs.php");
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	// Création d'un Article Libre (AL)	
	$tarifAl = [];	
	$tarifAl["refSociete"] = REF_SOCIETE; // Societe sur laquelle sera cree le tarif
	$tarifAl["codeTarif"] = 'MON_AL'; // Code technique du tarif - Il doit être unique
	$tarifAl["desiTarif"] = 'Désignation de l\'AL MON_AL'; //designation de l'AL
	$tarifAl["type"] = 0; //0 AL 1 Abonnement
	$tarifAl["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAl["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par defaut
	$tarifAl["montantTtc"] = 10; //Obtenu
	$tarifAl["servir"] = 1; //  
	$tarifAl["familleTarif"] = "REVUE"; // Famille 
	
	print "Creation du tarif Article Libre<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAl);
	
	if(property_exists($response, 'value')) {
		print "refTarif du nouveau tarif = ".$response->value->refTarif."<br><br>";
	}
	
	
	
	// Création d'un ABONNEMENT
	$tarifAbo = [];
	$tarifAbo["refSociete"] = REF_SOCIETE; // Societe sur laquelle sera cree le tarif
	$tarifAbo["codeTarif"] = 'MON_ABO'; // Code technique du tarif - Il doit être unique
	$tarifAbo["desiTarif"] = 'Désignation de l\'abonnement MON_ABO'; //designation de l'abonnement
	$tarifAbo["type"] = 1; //0 AL 1 Abonnement
	$tarifAbo["refTitre"] = 1; //Obtenu par l'api titre
	$tarifAbo["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAbo["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par defaut
	$tarifAbo["montantTtc"] = 10; //Obtenu
	$tarifAbo["servir"] = 2; //Nombre d'exemplaire a servir
	$tarifAbo["familleTarif"] = "PRELEVEMENT"; // Famille 

	print "Creation du tarif Abonnement<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAbo);
	
	if(property_exists($response, 'value')) {
		print "refTarif du nouveau tarif = ".$response->value->refTarif."<br><br>";
	}
?>
