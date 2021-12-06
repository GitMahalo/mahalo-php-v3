<?php
require_once("../resttbs.php");

//TRAITEMENT DES CALL API

$token = getToken(LOGIN, CREDENTIAL);

$params = [
    "maxResults" => 1, //Champ obligatoire compris entre 1 et 100
    "offset" => 0,
    "sortOrder" => -1, //permet de trier dans l'ordre croissant (<=>1) ou décroissant (<=>-1) sur le sortField
    "sortField" => "codeClient" //permet de filtrer la colonne codeClient
];


//RECHERCHE PAR NUMERO DE TELEPHONE en mode commence par
//La recherche n'est pas case sensitive
$modeStr = "commence par";
$mode="startsWith";
$telephone = "0492";

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


//RECHERHCE PAR NUMERO DE TELEPHONE en mode ne commence pas par
$modeStr = " ne commence pas par";
$mode="!startsWith";
$telephone = "0492";

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


//RECHERCHE PAR NUMERO DE TELEPHONE mode +startsWith
$telephones = ["21577", "35496", "75419"];
$filters = [ "telephone" => [
    "value" => $telephones,
    "matchMode" => "+startsWith"
]
];

$params["filters"] = json_encode($filters);
print "Nombre de client ayant les telephones contenant = ".print_r($telephones, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

print "Recherche du client ayant les telephones = ".print_r($telephones, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
?>
