<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 4604659;
	$typeAction = "Logistique";
	
	$filters =  [ "codeClient" => [
			"value" =>  $codeClient,
			"matchMode"=> "equals"
			],
			 "typeAction" => [
			 		"value" =>  $typeAction,
			"matchMode"=> "equals"
			]
		];
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des codes de selections du client $codeClient pour le type d'action $typeAction <br>";
	$params = [
			"maxResults" => 10,
			"filters" => json_encode($filters)
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/action", $token, $params);

?>
