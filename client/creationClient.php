<?php
	require_once("../resttbs.php");
	
	// CREATION DU CLIENT	
	$client = [];		
	$client["email"] = 'lenouveauclient@email.fr';
	$client["typeClient"] = 0; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["origineAbm"] = "ABM"; //Origine du client
	$client["civilite"] = 'M';
	$client["nom"] = 'LE CLIENT';
	$client["prenom"] = 'LE CLIENT';
	$client["societe"] = 'CL';
	$client["adresse1"] = '';
	$client["adresse2"] = '24 RUE DES FLEURS';
	$client["adresse3"] = '';
	$client["cp"] = '92100';
	$client["ville"] = 'BOULOGNE BILLANCOURT';
	$client["motPasseAbm"] = 'LEMOTDEPASSE';
	$client["codeIsoPays"] = "FR";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";
?>
