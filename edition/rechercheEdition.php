<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE D'UNE EDITION<br>";
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
		"maxResults" => 10, // champs obligatoire compris entre 1 et 100
		"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
		"sortField" => "refEdition" // permet de filtrer sur la colonne refEdition
	];

	// RECHERCHE EN FONCTION DU CODE_EDITION
	$codeEdition = "015";
	$filters =  [ "codeEdition" => [
		"value" =>  $codeEdition,
		"matchMode"=> "equals"
		]
	];

	$params["filters"] = json_encode($filters);

	print "Recherche de l'édition = ".$codeEdition."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/edition/", $token, $params);

	
	// RECHERCHE EN FONCTION DU CODE_EDITION
	$libEdition = "Nice";
	$filters =  [ "libEdition" => [
		"value" =>  $libEdition,
		"matchMode"=> "startsWith"
		]
	];

	$params["filters"] = json_encode($filters);

	print "Recherche de l'édition = ".$libEdition."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/edition/", $token, $params);
	
?>
