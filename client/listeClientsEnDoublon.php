<?php
	require_once("../resttbs.php");
	
    // recherche stricte de doublon client en fonction des critères de doublon définis sur la société

	//LECTURE DU REFERENTIEL Client
	
    // 'contact' complété en fonction des critères de doublon définis sur la société
    // par exemple : nom + prénom ou email...
    // remarque on ne tient pas compte des majuscules / minuscules
    $contact =  [ 
            "nom" => "TEST NOM",
            "prenom" => "TEST PRENOM"
    ];  

    $params = [
        "contact" => json_encode($contact),
        "refSociete" => 1 // OBLIGATOIRE pour la liste de clients en doublon

    ];
	
    //TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Total de clients en doublons<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/duplicates/count", $token, $params);
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Liste de clients en doublons<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/duplicates", $token, $params);

?>