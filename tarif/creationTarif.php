<?php
	require_once("../resttbs.php");
	
	// TARIF AL	
	$tarifAl = [];	
	$tarifAl["refSociete"] = REF_SOCIETE; // Societe sur laquelle sera créé le tarif
	$tarifAl["codeTarif"] = 'MON_AL_11'; // Code technique du tarif
	$tarifAl["type"] = 0; //0 AL 1 Abonnement
	$tarifAl["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAl["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par défaut
	$tarifAl["montantTtc"] = 10; //Obtenu
	
	// TARIF ABONNEMENT
	$tarifAbo = [];
	$tarifAbo["refSociete"] = REF_SOCIETE; // Societe sur laquelle sera créé le tarif
	$tarifAbo["codeTarif"] = 'MON_ABO_11'; // Code technique du tarif
	$tarifAbo["type"] = 1; //0 AL 1 Abonnement
	$tarifAbo["refTitre"] = 1; //Obtenu par l'api titre
	$tarifAbo["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAbo["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par défaut
	$tarifAbo["montantTtc"] = 10; //Obtenu
	$tarifAbo["servir"] = 1; //Nombre d'exemplaire à servir
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du tarif Article Libre<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAl);
	if(property_exists($response, 'value')) {
		print "refTarif du nouveau tarif = ".$response->value->refTarif."<br><br>";
	}
	
	print "Creation du tarif Abonnement<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAbo);
	
	if(property_exists($response, 'value')) {
		print "refTarif du nouveau tarif = ".$response->value->refTarif."<br><br>";
	}
?>
