<?php
	require_once("./resttbs.php");
	
	print "RECHERCHE DE STOCK <br>";
	print "La recherche filtree s'effectue grace à la structure filters.<br>";
	print "Il est possible de filtrer sur un ou pluusieurs champs<br>";
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
	
	$libelle = "mon_libelle";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 10,
			"offset" => 0
	];

	//RECHERCHE AVEC LIBELLE DU STOCK en mode equals
	
	$filters =  [ "libelleStock" => [
			"value" =>  $libelle,
			"matchMode"=> "equals"
			]
	];
	
	$params["filters"] = json_encode($filters);

	print "Nombre de stock ayant libelle = ".$libelle."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/stock/count", $token, $params);
	
	print "Recherche du stock ayant le libellé = ".$libelle."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/stock", $token, $params);
	
	print "RESULTAT : <br>";
	print_r ($response);
?>
