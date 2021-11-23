<?php
    require_once("../resttbs.php");
    header( 'content-type: text/html; charset= utf-8' );
	
	print "Recherche de client par modèle de doublon<br>";
	print "La recherche s'effectue soit :<br>";
    print "- par le modèle de doublon présent par défaut sur l'entité société.<br>";
    print "- en passant la référence du modèle de doublon à utiliser<br>";
	print "<span style='color: red'>Attention tous les critères actifs du modèles de doublon doivent être renseignés, les vides ou null seront ignorés et aucun doublon ne sera retournée dans ce cas</span></span><br>";
    print "La recherche est non sensible à la casse et aux caractères spéciaux<br>";
	print "<br>";
	print "<br>";
	print 'Valeur possible : {"nom":"","prenom":"","adresse2":"","cp":"","ville":"","email":"","telephone":"","codeIsoPays":"","societe":""}';
    print "<br>";
    print "<br>";
	print 'Subtilité :<br>';
    print '1- En renseignant adresse2 qui correspond à la ligne N° et nom de voie, la fonction en déduire les infos noVoie et motDirecteur disponible dans les modèles de doublon<br>';
    print '2- codeIsoPays sera utile pour toutes les adresses postales étrangères pour éviter justement de prendre en compte noVoie et motDirecteur même si le modèle est paramétré ainsi. En effet pour les adresses étrangères, ces infos ne sont jamais valorisées<br>';
    print "<br>";
	print "<br>";
    print 'Exemple<br>';

    $refModeleDoublon=2;
    print "Avec un modèle de doublon ayant : nom,prenom,cp,ville,no voie et mot directeur dont la référence est : $refModeleDoublon<br>";

    //TRAITEMENT DES CALL API

    $token = getToken(LOGIN,CREDENTIAL);

    $contact = [
        "nom" => "Dupont",
        "prenom" => "Robert",
        "cp" => "44000",
        "ville" => "NANTES",
        "adresse2" => "10 BOULEVARD MITTERAND"
    ];

    $params = [
        "maxResults" => 1, // champs obligatoire compris entre 1 et 100
        "offset" => 0,
        "sortOrder" => -1,
        "refModeleDoublon" => $refModeleDoublon,
    ];

    $params["contact"] = json_encode($contact);

    print "Nombre de client en doublon <br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/duplicates/count", $token, $params);

    print "Recherche des clients en doublon<br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/client/duplicates", $token, $params);

?>