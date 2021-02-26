<?php
	require_once("../resttbs.php");
	
	// MODIFICATION DU CLIENT
	$codeClient = 132436; // code client du client à modifier

	$client = [];
	$client["codeClient"] = $codeClient; // OBLIGATOIRE
	// $client["email"] = 'clientmodifie@email.fr';
	// $client["typeClient"] = 0; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	// $client["origineAbm"] = "ABM"; //Origine du client
	// $client["civilite"] = 'M';
	// $client["nom"] = 'NOM CLIENT';
	$client["prenom"] = 'PRENOM CLIENT';
	// $client["societe"] = 'SOC CLIENT';
	// $client["adresse2"] = '24 RUE DES TESTS';
	// $client["cp"] = '92100';
	// $client["ville"] = 'BOULOGNE BILLANCOURT';
	// $client["motPasseAbm"] = 'LEMOTDEPASSE';
	// $client["codeIsoPays"] = "FR";
	// etc...
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Modification du client codeClient = ".$codeClient."<br>";
	$response = callApiPatch("/editeur/".REF_EDITEUR."/client/".$codeClient, $token, $client);
	
	print "codeClient du client modifié = ".$response->value->codeClient."<br><br>";
?>
