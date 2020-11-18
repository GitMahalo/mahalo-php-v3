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
	
	$email = "monemail@gmail.com";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 1,
			"offset" => 0
	];
	
	//RECHERCHE AVEC EMAIL en mode equals
	
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
		
	//RECHERCHE PAR NUMERO DE PORTABLE en mode equals
	//La recherche n'est pas case sensitive
	$modeStr = " égale à ";
	$mode="equals";
	$telephone = "0682026204";
	
	$filters =  [ "portable" => [
			"value" =>  $telephone,
			"matchMode"=> $mode
	]
			
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le portable ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le portable ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE PAR NUMERO DE PORTABLE en mode termine par
	//La recherche n'est pas case sensitive
	$modeStr = "termine par";
	$mode="endsWith";
	$telephone = "82026204";
	
	$filters =  [ "portable" => [
			"value" =>  $telephone,
			"matchMode"=> $mode
	]
			
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le portable ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le portable ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE PAR NUMERO DE TELEPHONE en mode equals
	//La recherche n'est pas case sensitive
	$modeStr = " égale à ";
	$mode="equals";
	$telephone = "0251658974";
	
	$filters =  [ "telephone" => [
			"value" =>  $telephone,
			"matchMode"=> $mode
	]
			
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE PAR NUMERO DE TELEPHONE en mode termine par
	//La recherche n'est pas case sensitive
	$modeStr = "termine par";
	$mode="endsWith";
	$telephone = "652430269";
	
	$filters =  [ "telephone" => [
			"value" =>  $telephone,
			"matchMode"=> $mode
		]
			
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE PAR NUMERO DE TELEPHONE en mode commence par
	//La recherche n'est pas case sensitive
	$modeStr = "commence par";
	$mode="startsWith";
	$telephone = "065243";
	
	$filters["telephone"]["matchMode"] = $mode;
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE PAR NUMERO DE TELEPHONE en mode contient
	//La recherche n'est pas case sensitive
	$modeStr = "contient";
	$mode="contains";
	$telephone = "65243";
	
	$filters["telephone"]["matchMode"] = $mode;
	
	$params["filters"] = json_encode($filters);
	print "Nombre des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients dont le telephone ".$modeStr." ".$telephone."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);

?>
