<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture

    // Recupere tous les abonnements d'une commande 
	$filters = ["noFacture" => ["value" => "F220300243", "matchMode" => "equals"]];

    $params = [
    "maxResults" => 1, // champs obligatoire compris entre 1 et 100
    "filters" => json_encode($filters)
    ];
    
    //TRAITEMENT DES CALL API
    
    $token = getToken(LOGIN,CREDENTIAL);
    
    print "Recupere la facture : ".$filters["noFacture"]["value"]." <br><br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/facture", $token, $params);

?>
