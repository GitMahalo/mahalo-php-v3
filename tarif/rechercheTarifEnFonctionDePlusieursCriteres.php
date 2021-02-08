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
	
	

	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction de différents criteres de recherche (montantTtc, invisible) avec un classement par ref_tarif
	$montantTTC = 200;
	$filters = ["montantTtc" => ["value" => $montantTTC, "matchMode" => "equals"],	// montantTTC : montant Ttc du tarif
				"invisible" => ["value" => false, "matchMode" => "equals"] // invisible : false pour voir uniquement les tarifs qui ne sont pas 'invisibles'
			];  

	$params = [
			"maxResults" => 100, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];

	print "Nombre de tarif visible dont le montantTtc = ".$montantTTC."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);

	print "Recherche des tarifs visible dont le montantTtc = ".$montantTTC."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);



	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction de différents criteres de recherche (montantHt, refTitre) avec un classement par ref_tarif
	$montantHt = 60.26;
	$filters = ["montantHt" => ["value" => $montantHt, "matchMode" => "equals"],	//  montant Htc du tarif
				"refTitre" => ["value" => 1, "matchMode" => "equals"] // refTitre
			];  

	$params = [
			"maxResults" => 100, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];

	print "Nombre de tarif du refTitre = 1 dont le montantHt = ".$montantHt."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);

	print "Recherche des tarifs du refTitre = 1  dont le montantHt = ".$montantHt."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
?>
