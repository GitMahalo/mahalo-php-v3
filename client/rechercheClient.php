<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$email = "monemail@gmail.com";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 1,
			"offset" => 0
	];
	
	print "Recherche du client ayant l'email = ".$email."<br>";
	$filters =  [ "email" => [
			"value" =>  $email,
			"matchMode"=> "equals"
			]
		];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de client ayant l'email = ".$email."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche du client ayant l'email = ".$email."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//La recherche n'est pas case sensitive
	$prenom = "Robert";
	$nom = "Martin";
	
	print "Recherche du client ayant comme nom et prenom = ".$nom." ".$prenom." <br>";
	$filters =  [ "prenom" => [
			"value" =>  $prenom,
			"matchMode"=> "equals"
			],
			"nom" => [
					"value" =>  $nom,
					"matchMode"=> "equals"
			]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de client ayant comme nom et prenom = ".$nom." ".$prenom."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche du client ayant comme nom et prenom = ".$nom." ".$prenom."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);

?>
