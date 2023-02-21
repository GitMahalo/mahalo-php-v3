<?php
    require_once("../resttbs.php");
    
    //LECTURE DU REFERENTIEL Facture
    
    // Récupère la facture pour un numéro de commande donné
    $extra = ["noCommande" => "123456"];
    
    $params = [
        "maxResults" => 10, // champs obligatoire compris entre 1 et 100
        "extraParams" => json_encode($extra)
    ];
    
    //TRAITEMENT DES CALL API
    
    $token = getToken(LOGIN, CREDENTIAL);
    
    print "Récupère la facture pour un numéro de commande donné : " . $extra["noCommande"] . " <br><br>";
    $response = callApiGet("/editeur/" . REF_EDITEUR . "/facture", $token, $extra);
    
    $facture = $response->value;
    
    $refFacture = $facture->refFacture;
    
    // Affichage de la facture au format pdf
    print "Pour avoir la facture au format PDF voir l'exemple : getFacturePdf.php avec la refFacture : " . $refFacture . " <br><br>";
?>
