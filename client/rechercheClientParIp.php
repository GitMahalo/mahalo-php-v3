<?php
require_once("../resttbs.php");

print "RECHERCHE de client par ip<br>";
print "La recherche par adresse ip s'effectue via une adresse ip source et l'api plageip.<br>";
print "Cela retourne tous les clients dont l'ip source est inclue dans au moins une plage d'ip des clients<br>";

//TRAITEMENT DES CALL API

$token = getToken(LOGIN,CREDENTIAL);

$ip = '192.168.1.8';

$params = [
    "maxResults" => 5, // champs obligatoire compris entre 1 et 100
    "adresseIp" => $ip,
];

print "Nombre de plage d'ip client correspondant à l'ip ".$ip."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/plageip/count", $token, $params);

print "Recherche des clients correspondant à l'ip ".$ip."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/plageip", $token, $params);

//Récupération des clients
if (property_exists($response, 'value')) {
    $clientsIp = $response->value;
    foreach ($clientsIp as $plageIp) {
        print "Lecture du client codeClient = ".$plageIp->codeClient."<br>";
        $response = callApiGet("/editeur/".REF_EDITEUR."/client/".$plageIp->codeClient, $token);
    }
}

?>
