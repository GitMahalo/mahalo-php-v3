<?php
	require_once("../resttbs.php");
	
	// Recupere tous les abonnements non termines du client à la date du jour 
	
	$filters = ["dateFinAbonnement" => ["value" => ["2020-09-25",""], "matchMode" => "range"], // permet de récupérer les abonnements dont la date de fin > à la date
				"codeClient" => ["value" => 4998122, "matchMode" => "+equals"],
				"refTitre" => ["value" => 8, "matchMode" => "+equals"]]; 
	
	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou décroissant (<=> -1) sur le sortField
			"sortField" => "dateFinAbonnement" // permet de filtrer sur la colonne dateFin
	];
	
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Recupere tous les abonnements non termines du client ".$filters["codeClient"]["value"]." a la date du jour<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
	
?>