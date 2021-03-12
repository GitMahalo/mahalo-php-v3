<?php
	require_once("../resttbs.php");
	
	// EXEMPLE de modification du client de typeClient = 0 (NORMAL) vers typeClient = 1 (TIERS)

	// CREATION DU CLIENT DE TYPE 0
	$client = [];		
	$client["email"] = 'lenouveauclient@email.fr';
	$client["typeClient"] = 0; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["civilite"] = 'M';
	$client["nom"] = 'NOM';
	$client["prenom"] = 'PRENOM ';
	$client["adresse2"] = '24 RUE DES TESTS';
	$client["cp"] = '35000';
	$client["ville"] = 'RENNES';
	$client["codeIsoPays"] = "FR";
	$client["portable"] = "0682026204";
	
	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";

	// MODIFICATION DU CLIENT EN TYPE = 1 (TIERS)
	$codeClientTiers = $response->value->codeClient; // code client du client - Obligatoire

	$client = [];
	$client["codeClient"] = $codeClientTiers; // OBLIGATOIRE	
	// Ajout uniquement des données qu'on veut modifier.
	$client["typeClient"] = 1; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	
	//TRAITEMENT DES CALL API
	
	print "Modification du client codeClient = ".$codeClientTiers."<br>";
	$response = callApiPatch("/editeur/".REF_EDITEUR."/client/".$codeClientTiers, $token, $client);
	
	print "codeClient du client modifié = ".$response->value->codeClient."<br><br>";
	
	// FIN EXEMPLE de modification du client de typeClient = 0 (NORMAL) vers typeClient = 1 (TIERS)


	
	// EXEMPLE de modification du client de typeClient = 0 (NORMAL) vers typeClient = 2 (PAYE PAR)
	// CREATION DU CLIENT DE TYPE 0
	$client = [];		
	$client["email"] = 'clientA@email.fr';
	$client["typeClient"] = 0; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["civilite"] = 'M';
	$client["nom"] = 'NOM A';
	$client["prenom"] = 'PRENOM A';
	$client["adresse2"] = '1 RUE DES TESTS';
	$client["cp"] = '75000';
	$client["ville"] = 'PARIS';
	$client["codeIsoPays"] = "FR";
	$client["portable"] = "0682026204";
	
	//TRAITEMENT DES CALL API
	print "Creation du client<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du nouveau client = ".$response->value->codeClient."<br><br>";

	// MODIFICATION DU CLIENT EN TYPE = 2 (PAYE PAR)
	$codeClient = $response->value->codeClient; // code client du client - Obligatoire

	$client = [];
	$client["codeClient"] = $codeClient; // OBLIGATOIRE	
	// Ajout uniquement des données qu'on veut modifier.
	$client["typeClient"] = 2; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$client["codeTiers"] = $codeClientTiers; // Code client du Tiers - OBLIGATOIRE dans le cas d'un payé par
	
	//TRAITEMENT DES CALL API
	
	print "Modification du client codeClient = ".$codeClient."<br>";
	$response = callApiPatch("/editeur/".REF_EDITEUR."/client/".$codeClient, $token, $client);
	
	print "codeClient du client modifié = ".$response->value->codeClient."<br><br>";
	// FIN EXEMPLE de modification du client de typeClient = 0 (NORMAL) vers typeClient = 2 (PAYE PAR)
?>
