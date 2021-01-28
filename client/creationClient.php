<?php
	require_once("../resttbs.php");
	
	// CREATION DU CLIENT	
	$client = [];		
	$client["email"] = 'lenouveauclient@email.fr';
	$client["typeClient"] = 0; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["civilite"] = 'M';
	$client["nom"] = 'NOM';
	$client["prenom"] = 'PRENOM ';
	// $client["adresse1"] = '';
	$client["adresse2"] = '24 RUE DES TESTS';
	// $client["adresse3"] = '';
	$client["cp"] = '35000';
	$client["ville"] = 'RENNES';
	$client["codeIsoPays"] = "FR";
	$client["portable"] = "0682026204";
	// $client["bic"] = "BDFEFR2L";
	// $client["iban"] = "FR7630001007941234567890185";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";
?>
