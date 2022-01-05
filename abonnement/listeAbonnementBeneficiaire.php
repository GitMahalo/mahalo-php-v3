<?php
	require_once("../resttbs.php");
	$codeClient = 10000; // beneficiaire d'un abonnement

    print "Recupere tous les abonnements du client $codeClient dont les abonnements bénéficiaires<br>";
    print "Cela retourne tous les abonnements dont les abonnements bénéficiaires parce que le codeClient est présent dans les filtres.<br>";
    print "Sans filtre sur le codeClient, les abonnements bénéficiaires ne sont pas présents lors des appels de l’api abonnement,<br>";
    print "il faut cibler explicitement un codeClient pour obtenir les abonnements dont le client est bénéficiaire en plus de ces propres abonnements.<br>";
    print "Le filtre client peut être combiné avec d'autres filtres<br>";
    print "Sur un abonnnement beneficiaire :<br><br>";
    print "codeClient == proprietaire de l'abonnement<br>";
    print "codeBeneficiaire == beneficiaire de l'abonnement == $codeClient dans notre exemple<br>";
	
	$filters = ["codeClient" => ["value" => $codeClient, "matchMode" => "equals"]];
	
	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters)
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere tous les abonnements non termines du client ".$filters["codeClient"]["value"]." a la date 2020-09-25 <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
	
?>