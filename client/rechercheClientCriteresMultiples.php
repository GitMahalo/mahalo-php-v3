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
	
	//RECHERCHE AVEC NOM ET PRENOM en mode equals
	//La recherche n'est pas case sensitive
	$prenom = "Robert";
	$nom = "Martin";
	
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
	
	//RECHERCHE des clients qui possède un CS et qui ont le cp XXXX
	//La recherche n'est pas case sensitive
	$refCs = "500";
	$cp = "35000";
	
	$filters =  [ "cs.refCs.refCs" => [
					"value" =>  $refCs,
					"matchMode"=> "equals"
			],
			"cp" => [
					"value" =>  $cp,
					"matchMode"=> "equals"
			]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de clients ayant le cs=".$refCs." et le cp= ".$cp."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients ayant le cs=".$refCs." et le cp= ".$cp."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
	
	//RECHERCHE des clients qui possède un CS qui contient la valeur XXXX et qui ont le cp YYYY
	//La recherche n'est pas case sensitive
	$refCs = "500";
	$valeurCS = "XXXX";
	$cp = "35000";
	
	$filters =  [ "cs.refCs.refCs" => [
					"value" =>  $refCs,
					"matchMode"=> "equals"
			],
			"cs.libAlpha" => [
					"value" =>  $valeurCS,
					"matchMode"=> "equals"
			],
			"cp" => [
					"value" =>  $cp,
					"matchMode"=> "equals"
			]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de clients ayant le cs=".$refCs.", la valeur du cs=".$valeurCS." et le cp= ".$cp."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);
	
	print "Recherche des clients ayant le cs=".$refCs.", la valeur du cs=".$valeurCS." et le cp= ".$cp."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);

?>
