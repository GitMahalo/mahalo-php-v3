<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE DE Commande<br>";
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
	
    $refAction = 1000;

	$params = [
			"maxResults" => 1,
			"offset" => 0
	];
    
    print "Recupération de la commande avec la refAction = ".$refAction."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/commande/".$refAction, $token, $params);
	
    //RECHERCHE AVEC noCommandeBoutique en mode equals
    
    $noCommandeBoutique="MONNUMEROBOUTIQUE";
	
	//RECHERCHE AVEC EMAIL en mode equals
	
	$filters =  [ "noCommandeBoutique" => [
			"value" =>  $noCommandeBoutique,
			"matchMode"=> "equals"
			]
		];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de commande ayant noCommandeBoutique = ".$noCommandeBoutique."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/commande/count", $token, $params);
	
	print "Recherche de la commande ayant noCommandeBoutique = ".$noCommandeBoutique."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/commande", $token, $params);

?>
