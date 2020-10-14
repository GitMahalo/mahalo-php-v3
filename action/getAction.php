<?php
require_once("../resttbs.php");

//LECTURE DU REFERENTIEL Client

$codeClient = 4604659;

$filters =  [ "codeClient" => [
		"value" =>  $codeClient,
		"matchMode"=> "equals"
	]
];

//TRAITEMENT DES CALL API

$token = getToken(LOGIN,CREDENTIAL);

print "Lecture des codes de selections du client ".$codeClient."<br>";
$params = [
		"maxResults" => 2,
		"filters" => json_encode($filters)
];
$response = callApiGet("/editeur/".REF_EDITEUR."/action", $token, $params);

?>
