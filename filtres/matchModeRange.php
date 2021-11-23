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


//RECHERCHE PAR date de creation en mode range
// pour cette recherche on précise sur quelle table on recherche
// car il peut y avoir confusion entre la table t_adresses (adr) et t_client(c)
$hier = new DateTime();
$hier->setTimeZone(new DateTimeZone('Europe/Paris'));
$hier->sub(new DateInterval('P1D'));
$hier->setTime(0, 0);
$hier->setTimeZone(new DateTimeZone('UTC'));

$dt = new DateTime();
$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
$dt->setTime(0, 0);
$dt->setTimeZone(new DateTimeZone('UTC'));


$filters = ["date_debut" => ["value" => [$hier->format('2017-07-26'), $dt->format('Y-m-d')], "matchMode" => "range"]];

print "Nombre de client compris entre deux dates ".print_r($filters, true)."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

print "Recherche de client compris entre deux dates ".print_r($filters, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);


$filters = ["date_debut" => ["value" => [$hier->format('2017-07-26'), ""], "matchMode" => "range"]];

print "Nombre de client avant cette date ".print_r($filters, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

print "Recherche de client avant cette date ".print_r($filters, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);


$filters = ["date_debut" => ["value" => [$dt->format('Y-m-d'), ""], "matchMode" => "range"]];

print "Nombre de client apres cette date ".print_r($filters, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

print "Recherche de client apres cette date ".print_r($filters, true)."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);
?>
