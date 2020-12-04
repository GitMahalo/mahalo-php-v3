<?php
	require_once("../resttbs.php");
	
	// CREATION DU CLIENT	
	$client = [];		
	$client["email"] = 'contactTiers@email.fr';
	$client["typeClient"] = 2; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["codeTiers"] = 2490970; // Code client du Tiers - obligatoire dans le cas d'un payé par
	$client["civilite"] = 'MLLE';
	$client["nom"] = 'CONTACT PAYE PAR';
	$client["prenom"] = 'LILI';
	$client["adresse1"] = '';
	$client["adresse2"] = '4 RUE DE PARIS';
	$client["adresse3"] = '';
	$client["cp"] = '75000';
	$client["ville"] = 'PARIS';
	$client["codeIsoPays"] = "FR";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";
?>
