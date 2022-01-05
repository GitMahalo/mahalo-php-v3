<?php
	require_once("../resttbs.php");
	header( 'content-type: text/html; charset= utf-8' );
	
	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);

	$suffixTarifUnique = "";

	print "Création d'un Article Libre (AL)<br><br>";

	$tarifAl = [];
	$tarifAl["refSociete"] = REF_SOCIETE; // Societe sur laquelle sera cree le tarif
	$tarifAl["codeTarif"] = 'AL_10'.$suffixTarifUnique; // Code technique du tarif - Il doit être unique
	$tarifAl["desiTarif"] = 'Désignation AL_10'.$suffixTarifUnique; //designation de l'AL
	$tarifAl["typeTarif"] = 0; // si 0 et refTitre non renseigne alors article libre
	$tarifAl["codeTva"] = "A"; //Obtenu par l'api tva/list/code
	//$tarifAl["arrondiTtc"] = 1; //Arrondir sur TVA ou non => 1 par defaut
	$tarifAl["montantTtc"] = 10;
	$tarifAl["servir"] = 1; //  
	$tarifAl["familleTarif"] = "REVUE"; // Famille 
	
	print "Creation de l'offre Article Libre ".$tarifAl["codeTarif"]."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/tarif", $token, $tarifAl);
	
	if(property_exists($response, 'value')) {
		print "refTarif de l'offre créée = ".$response->value->refTarif."<br><br>";
	}
?>
