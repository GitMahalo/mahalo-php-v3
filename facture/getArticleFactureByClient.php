<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL article

    $codeClientLivre = 540688;

    // Recupere toutes les lignes de factures liées à un article libre
	$filters = [
        "codeClientLivraison.codeClient" => ["value" => $codeClientLivre, "matchMode" => "equals"],
        "avoirOn" => ["value" => false, "matchMode" => "equals"], //On exclu les avoirs
        ];

    $params = [
    "maxResults" => 10, // champs obligatoire compris entre 1 et 100
    "filters" => json_encode($filters)
    ];

    //TRAITEMENT DES CALL API

    $token = getToken(LOGIN,CREDENTIAL);

    // Affichage des données
    print "Recupere les " . $params["maxResults"] . " premières lignes de factures d'articles libres du client : ".$codeClientLivre." <br><br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/article", $token, $params);

    $lignefactures = $response->value;
    print "Voici les articles achetés par le client ".$codeClientLivre." : <br><br>";
    foreach($lignefactures as $lignefacture){
        print "Code offre : ".$lignefacture->codeTarif." <br><br>";
    }
?>