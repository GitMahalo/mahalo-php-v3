<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE DE Tarif<br>";
	print "La recherche filtree s'effectue grace a la structure filters.<br>";
	print "Il est possible de filtrer sur un ou plusieurs champs<br>";
	print "La recherche sur chaque champ est independante et prendre un des modes suivants :<br>";
	print "startsWith (mode par defaut) ==> like %XXX<br>";
	print "contains  ==> like %XXX%<br>";
	print "endsWith  ==> like XXX%<br>";
	print "equals ==> == XXX<br>";
	
	print "ATTENTION AVEC LES PERFORMANCES SUR LES NOT LIKE car le nombre de resultat peut-etre consequent<br>";
	print "!startsWith (mode par defaut) ==> not like %XXX<br>";
	print "!contains  ==> not like %XXX%<br>";
	print "!endsWith  ==> not like XXX%<br>";
	print "<br>";
	print "<br>";
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
		"maxResults" => 2, // champs obligatoire compris entre 1 et 100
		"offset" => 0,
		"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
		"sortField" => "refTarif" // permet de filtrer sur la colonne codeClient
	];
	$codeTarif = "NMN-1A";
	
	//RECHERCHE AVEC codeTarif en mode startsWith
	$filters =  [ "codeTarif" => [
			"value" =>  $codeTarif,
			"matchMode"=> "startsWith"
		]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de tarif commencant par ".$codeTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Recherche des tarifs commencant par ".$codeTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);

?>
