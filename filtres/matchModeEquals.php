<?php
    require_once("../resttbs.php");

    print "Le matchMode est une méthode qui permet de trier les différentes tables afin de retrouver plus facilement certaines données <br>";
    print "Il existe différents matchMode dont le Equals présenter ci-dessous <br>";
    print "<br>";
    print "<br>";

    //TRAITEMENT DES CALL API

    $token = getToken(LOGIN, CREDENTIAL);

    $params = [
        "maxResults" => 1, //Champ obligatoire compris entre 1 et 100
        "offset" => 0,
        "sortOrder" => -1, //permet de trier dans l'ordre croissant (<=>1) ou décroissant (<=>-1) sur le sortField
        "sortField" => "codeClient" //permet de filtrer la colonne codeClient
    ];

    //RECHERCHE DE CLIENT AVEC EMAIL mode equals (verification qu'au moins une des valeurs est égale a celles rechercher)
    $email = "lenouveauclient@email.fr";
    $filters = [ "email" => [
        "value" => $email,
        "matchMode" => "equals"
        ]
    ];

    $params["filters"] = json_encode($filters);
    print "Nombre de client ayant l'email = ".$email."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

    print "Recherche du client ayant l'email = ".$email."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);


    //RECHERCHE DE CLIENT SANS LE MAIL mode not equals

    $email = "lenouveauclient@email.fr";
    $filters = ["email" => [
        "value" => $email,
        "matchMode" => "!equals"
    ]
    ];

    $params["filters"] = json_encode($filters);
    print "Nombre de client n'ayant pas l'email ".$email."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

    print "Recherche des clients n'ayant pas l'email ".$email."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);


    //RECHERCHE DE CLIENT AVEC EMAIL mode +equals (verification que toutes les valeurs soit égale a celles rechercher)
    $emails = ["lenouveauclient@email.fr", "lancienclient@email.fr", "ceclientla@email.fr"];
    $filters = [ "email" => [
        "value" => $emails,
        "matchMode" => "+equals"
        ]
    ];

    $params["filters"] = json_encode($filters);
    print "Nombre de client ayant les email = ".print_r($emails, true)."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/count", $token, $params);

    print "Recherche du client ayant les email = ".print_r($emails, true)."<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client", $token, $params);


?>
