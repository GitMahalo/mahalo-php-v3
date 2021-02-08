<?php
	require_once("../resttbs.php");
	
	print "RECHERCHE DE Tarif<br>";
	print "La recherche filtree s'effectue grace a la structure filters.<br>";
	print "Il est possible de filtrer sur un ou plusieurs champs<br>";
	print "La recherche sur chaque champ est independante et prendre un des modes suivants :<br>";
	print "startsWith (mode par defaut) ==> like %XXX<br>";
	print "contains  ==> like %XXX%<br>";
	print "endsWith  ==> like XXX%<br>";
	print "equals ==> == XXX<br>";
	
	print "ATTENTION AVEC LES PERFORMANCES SUR LES NOT LIKE car le nombre de resultat peut-etre consequent<br>";
	print "!startsWith (mode par defaut) ==> not like %XXX<br>";
	print "!contains  ==> not like %XXX%<br>";
	print "!endsWith  ==> not like XXX%<br>";
	print "<br>";
	print "<br>";


	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);



	// LECTURE DU REFERENTIEL pour recupere les tarifs ayant pour ORIGINE D'ABONNEMENT CODEORIGINE avec un classement par ref_tarif
	$origineAbonnement = 500; // 500 : origine d'abonnement <=> code offre
	$codeOrigine = " REAB34";
	$filters = ["pc2.paramCs1.refCs" => ["value" => $origineAbonnement, "matchMode" => "equals"], // 500 : origine d'abonnement <=> code offre
				"libelleCs2" => ["value" => $codeOrigine, "matchMode" => "equals"]];   

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];

	print "Nombre de tarif du code origine = ".$codeOrigine."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Recherche des tarifs du code origine = ".$codeOrigine."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	
	
	
	// LECTURE DU REFERENTIEL pour recupere les tarifs ayant pour ORIGINE DE REABONNEMENT 'ACTAACJB' et en triant par refTarif
	$filters = ["pc2.paramCs1.refCs" => ["value" => 506, "matchMode" => "equals"], // 506 : origine de réabonnement
	"libelleCs2" => ["value" => " REAB34", "matchMode" => "equals"]]; 
	
	$params = [
		"maxResults" => 50, // champs obligatoire compris entre 1 et 100
		"filters" => json_encode($filters),
		"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
		"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
		
	];
	
	print "Nombre de tarif du code origine de reabonnement<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Lecture des tarifs pour l'origine de reabonnement avec tri sur la refTarif <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);



	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction de différents criteres de recherche avec un classement par ref_tarif
	$montantTTC = 45;
	$origineAbonnement = 500; // 500 : origine d'abonnement <=> code offre
	$codeOrigine = " REAB34";
	$codeTitre = "PP";
	$filters = ["montantTtc" => ["value" => $montantTTC, "matchMode" => "equals"],
				"pc2.paramCs1.refCs" => ["value" => $origineAbonnement, "matchMode" => "equals"], 
				"libelleCs2" => ["value" => $codeOrigine, "matchMode" => "equals"],
				"refTitre.titreAbrege" => ["value" => $codeTitre, "matchMode" => "equals"] 
			];  

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Nombre de tarif en fonction de différents critères de recherche<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);

	print "Recherche des tarifs de différents critères de recherche<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);

	
?>
