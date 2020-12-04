<?php
	require_once("../resttbs.php");
	
	// CREATION DU CLIENT	
	$client = [];		
	$client["email"] = 'contactTiers@email.fr';
	$client["typeClient"] = 1; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["civilite"] = 'M';
	$client["nom"] = 'CONTACT TIERS';
	$client["prenom"] = 'PRENOM';
	$client["adresse1"] = '';
	$client["adresse2"] = '24 RUE DES TESTS';
	$client["adresse3"] = '';
	$client["cp"] = '92100';
	$client["ville"] = 'BOULOGNE BILLANCOURT';
	$client["codeIsoPays"] = "FR";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";
?>
