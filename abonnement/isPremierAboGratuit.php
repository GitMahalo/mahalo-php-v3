<?php
	require_once("../resttbs.php");

    initHTML();

    // TRAITEMENT DES CALL API

    $token = getToken(LOGIN,CREDENTIAL, false);
	
	//LECTURE DU REFERENTIEL Abonnement
    $codeClient = 665266;

    $filters = ["abo.codeClient.codeClient" => ["value" => $codeClient, "matchMode" => "equals"],
        "abo.montantTtc" => ["value" => 0, "matchMode" => "equals"]];

    $params = [
        "filters" => json_encode($filters),
        "maxResults" => 100,
        "sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
		"sortField" => "dateFinAbonnement" // permet de filtrer sur la colonne dateFin
	];

    $response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);

    if (property_exists($response, 'value')) {
        $abonnements = $response->value;

        foreach($abonnements as $abonnement){
            if ($abonnement->etat == "01"){
                $filters = ["refTarif" => ["value" => $abonnement->refTarifFormule, "matchMode" => "equals"],
                    "refTarifReabo.refTarif" => ["value" => null, "matchMode" => "!equals"]];

                $params = [
                    "filters" => json_encode($filters),
                ];
                $response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
                if (property_exists($response, 'value') && $response->value == 1) {
                    print_rr("l'abonné a bien un gratuit en cours qui va chainer sur un payant");
                } else {
                    print_rr("l'abonné n'a pas de gratuit en cours");
                }
            }
        }
    }

    endHTML();
?>