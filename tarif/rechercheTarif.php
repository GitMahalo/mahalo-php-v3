<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE DE Tarif<br>";
	print "La recherche filtr�e s'effectue grace � la structure filters.<br>";
	print "Il est possible de filtrer sur un ou plusieurs champs<br>";
	print "La recherche sur chaque champ est ind�pendante et prendre un des modes suivants :<br>";
	print "startsWith (mode par d�faut) ==> like %XXX<br>";
	print "contains  ==> like %XXX%<br>";
	print "endsWith  ==> like XXX%<br>";
	print "equals ==> == XXX<br>";
	
	print "ATTENTION AVEC LES PERFORMANCES SUR LES NOT LIKE car le nombre de r�sultat peut-�tre cons�quent<br>";
	print "!startsWith (mode par d�faut) ==> not like %XXX<br>";
	print "!contains  ==> not like %XXX%<br>";
	print "!endsWith  ==> not like XXX%<br>";
	print "<br>";
	print "<br>";
	
	$tarif = "F3-3";
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	$params = [
			"maxResults" => 1,
			"offset" => 0
	];
	
	//RECHERCHE AVEC EMAIL en mode equals
	//{"codeTarif" : { "value" : "F3-33", "matchMode" : "startsWith" }}
	$filters =  [ "codeTarif" => [
			"value" =>  $tarif,
			"matchMode"=> "startsWith"
		]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de tarif commen�ant par ".$tarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Recherche des tarifs commen�ant par ".$tarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);

?>
