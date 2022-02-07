<?php
require_once("../resttbs.php");

initHTML();

$sequenceFormule='54069620220205162429964';
$createFacture=true;
$saveFacture=true;

// TRAITEMENT DES CALL API

$token = getToken(LOGIN,CREDENTIAL, false);

print "Lecture de la formule sequenceFormule = ".$sequenceFormule."<br>";
$response = callApiGet("/editeur/".REF_EDITEUR."/formule/sequence/".$sequenceFormule, $token);

if ($createFacture && property_exists($response, 'value')) {
    $formule = $response->value;
    $codeClient = $formule->codeClient;
    $ligneFactures=[];

    //Preparation de la facture correspondante
    $listRefAbo=[];
    foreach ($formule->abonnements as $abonnement) {
        $listRefAbo[] = $abonnement->refAbonnement;
    }
    $params = [
        "refAbonnement" => implode(",", $listRefAbo), // liste des abos de la formule
    ];

    $response = callApiGet("/editeur/" . REF_EDITEUR . "/lignefacture/prepare", $token, $params);
    if (property_exists($response, 'value')) {
        $ligneFactures = $response->value;
    }

    //AL ?

    if(count($ligneFactures) > 0) {
        //Sauvegarde de la facture

        $dt = new DateTime();
        $dt->setTimeZone(new DateTimeZone('Europe/Paris'));
        $dt->setTime(0, 0);
        $dt->setTimeZone(new DateTimeZone('UTC'));
        $dateFacture = $dt->format('Y-m-d\TH:i:s.\0\0\0');

        $dt = new DateTime();
        $dt->setTimeZone(new DateTimeZone('Europe/Paris'));
        $dt->sub(new DateInterval('P60D'));
        $dt->setTime(0, 0);
        $dt->setTimeZone(new DateTimeZone('UTC'));
        $dateEcheance = $dt->format('Y-m-d\TH:i:s.\0\0\0');

        $facture = [
            "codeClient" => $codeClient,//obligatoire
            "dateFacture" => $dateFacture, // date de la facture
            "dateEcheance" => $dateEcheance, // date echeance
            "montantHt" => 18.61,
            "montantTtc" => 19,
            "verrouillee" => true,
            "refSociete" => 1,
            "avoirOn" => false
        ];

        print_rr($facture);

        print_rr($ligneFactures);

        if ($saveFacture) {

            $response = callApiPost("/editeur/" . REF_EDITEUR . "/facture", $token, $facture);
            //Sauvegarde des lignes de facture

            if (property_exists($response, 'value')) {
                $refFacture = $response->value->refFacture;
                foreach ($ligneFactures as $ligneFacture) {
                    $ligneFacture->refFacture = $refFacture;
                    $response = callApiPost("/editeur/" . REF_EDITEUR . "/lignefacture", $token, $ligneFacture);
                }
            }

            //Creation d'un reglement
        }
    }
}

endHTML();

?>
