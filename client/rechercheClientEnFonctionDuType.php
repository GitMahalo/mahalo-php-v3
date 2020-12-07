<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE DE Client<br>";
	print "La recherche filtrée s'effectue grace à la structure filters.<br>";
	print "Il est possible de filtrer sur un ou plusieurs champs<br>";
	print "La recherche sur chaque champ est indépendante et prendre un des modes suivants :<br>";
	print "startsWith (mode par défaut) ==> like %XXX<br>";
	print "contains  ==> like %XXX%<br>";
	print "endsWith  ==> like XXX%<br>";
	print "equals ==> == XXX<br>";
	
	print "ATTENTION AVEC LES PERFORMANCES SUR LES NOT LIKE car le nombre de résultat peut-être conséquent<br>";
	print "!startsWith (mode par défaut) ==> not like %XXX<br>";
	print "!contains  ==> not like %XXX%<br>";
	print "!endsWith  ==> not like XXX%<br>";
	print "<br>";
	print "<br>";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 10, // champ obligatoire compris entre 0 et 100
			"offset" => 0
	];
	
	// Remarque le contact peut être de type 0 : client - 1 : tiers - 2 : payé par

	//RECHERCHE AVEC typeClient = 0 ou 1 cad de type 'client' OU 'tiers'
	$typeClient = ["0","1"];
	$filters =  [ "typeClient" => [
			"value" =>  $typeClient,
			"matchMode"=> "equals"
			]
		];
	
	$params["filters"] = json_encode($filters);

	print "Nombre de client de type = 'client' OU 'tiers'<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche du client de type = 'client' OU 'tiers'<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);

	
	//RECHERCHE AVEC typeClient = 2 cad de type 'payé par'
	$typeClient = "2";
	$filters =  [ "typeClient" => [
			"value" =>  $typeClient,
			"matchMode"=> "equals"
			]
		];
	
	$params["filters"] = json_encode($filters);

	print "Nombre de client de type = ".$typeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche du client de type = ".$typeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
		
?>
