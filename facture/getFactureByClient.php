<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture

    $codeClient = 540688;

    $params = [
        "maxResults" => 10, // champs obligatoire compris entre 1 et 100
        "codeClient" => $codeClient
    ];

    //TRAITEMENT DES CALL API

    $token = getToken(LOGIN,CREDENTIAL);

    // Affichage des données de la facture
    print "Recupere les " . $params["maxResults"] . " premières factures du client : ".$codeClient." <br><br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/facture", $token, $params);

    $factures = $response->value;

    foreach($factures as $facture){
        // Affichage des données des lignes de la facture
        print "Affichage des données des lignes de la facture = ".$facture->refFacture." <br><br>";
        $response = callApiGet("/editeur/".REF_EDITEUR."/lignefacture/details/" . $facture->refFacture, $token);

        // Affichage de la facture au format pfd
        print "Pour avoir la facture au format PDF voir l'exemple : getFacturePdf.php avec la refFacture : ".$facture->refFacture." <br><br>";

    }
?>