<?php
	require_once("../resttbs.php");
	
	// MODIFICATION DU CLIENT
	$codeClient = 2052929; // code client du client à modifier - Obligatoire

	$client = [];
	$client["codeClient"] = $codeClient;	
	// Ajout uniquement des données qu'on veut modifier.
	$client["email"] = 'email@test.com';
	$client["motPasseAbm"] = "123456";
	$client["typeClient"] = 2; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Modification du client codeClient = ".$codeClient."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $client);
	
	print "codeClient du client modifié = ".$response->value->codeClient."<br><br>";
?>
