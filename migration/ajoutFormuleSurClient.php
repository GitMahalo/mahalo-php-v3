<?php
require_once("../resttbs.php");

initHTML();

$codeClient=540696;
$refFormule=156; //reférence du tarif de formule DATE A DATE

$saveFormule=true;

// TRAITEMENT DES CALL API

$token = getToken(LOGIN,CREDENTIAL, false);


//print "Lecture du tarif refTarif = ".$refTarif."<br>";
//$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/".$refFormule, $token);

//print "Lecture du titre du tarif = ".$refTarif."<br>";
//$response = callApiGet("/editeur/".REF_EDITEUR."/titre/".$response->value->refTitre, $token);


$params = [
    "refTarif" => $refFormule, // obligatoire, codeTarif de la formule
    "codeClient" => $codeClient,//obligatoire
    "nbExemplaires" => 1, // quantite
    "codeParrain" => null, // si parrain
    "upgradeDowngrade" => false // si Upgrade / Downgrade
];

// Preparation de la formule et de ces composantes
$response = callApiGet("/editeur/".REF_EDITEUR."/formule/prepare", $token, $params);


$forceNumero=10;

$dateCustom = new DateTime();
$dateCustom->setTimeZone(new DateTimeZone('Europe/Paris'));
$dateCustom->sub(new DateInterval('P10D'));
$dateCustom->setTime(0, 0);
$dateCustom->setTimeZone(new DateTimeZone('UTC'));
$forceDateDebut = $dateCustom->format('Y-m-d\TH:i:s.\0\0\0\Z');

if(property_exists($response, 'value')) {
    $formule = $response->value;

    foreach ($formule->abonnements as $abonnement) {


        if($abonnement->estCalendaire) {
            //Modification de la date de début de l'abonnement si abonnement en date à date
            $paramsUpdateAbo = [
                "simulation" => true,
                "chain" => false,
                "dateDebut" => $forceDateDebut
            ];

            $responseAbo = callApiPost("/editeur/".REF_EDITEUR."/abonnement", $token, $abonnement, $paramsUpdateAbo);
            if(property_exists($responseAbo, 'value')) {
                $newAbo = $responseAbo->value;
                $abonnement->dateDebut = $newAbo->dateDebut;
                $abonnement->dateFin = $newAbo->dateFin;
                $abonnement->servir = $newAbo->servir;
            } else {
                die("Mise à jour de labonnement en échec");
            }

        } else {
            //Modification du pns de l'abonnement si abonnement en numéro à numéro
            $abonnement->pns = $forceNumero;
            $abonnement->dns = $abonnement->pns + $abonnement->servir - 1;
        }

        //Mise à jour des autres propriétés de l'abonnement si nécessaire

        // $abonnement->cs1 = "xxx";
        // $abonnement->cs2 = "xxx";
    }

    //print_rr($formule);

    if($saveFormule) {
        $params = [
            "formule" => $formule, // obligatoire
        ];
        //Enregistrement et création de la formule sur le client
        $response = callApiPost("/editeur/" . REF_EDITEUR . "/formule", $token, $params);

        if (property_exists($response, 'value')) {
            $formule = $response->value;

            print_rr("Sequence Formule=".$formule->sequence);
        }
    }
}

endHTML();

?>
