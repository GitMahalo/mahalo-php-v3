<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Tarif
	$refTarif = 1;
	
	//TRAITEMENT DES CALL API
	
	// $token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture du tarif refTarif = ".$refTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/".$refTarif, $token);
	


	//LECTURE DU REFERENTIEL codeTitre <=> titre abrégé avec un classement par ref_tarif
	$codeTitre = "VAP";
	$filters = ["refTitre.titreAbrege" => ["value" => $codeTitre, "matchMode" => "equals"]]; // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
	];
	$token = getToken(LOGIN,CREDENTIAL);

	print "Recherche des tarifs du code titre = ".$codeTitre."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);



	//LECTURE DU REFERENTIEL pour recupere les tarifs ayant pour origine d'abonnement WEB avec un classement par ref_tarif
	$origineAbonnement = 500;
	$codeOrigine = "CODEORIGINE";
	$filters = ["pc2.paramCs1.refCs" => ["value" => $origineAbonnement, "matchMode" => "equals"], // 500 : origine d'abonnement <=> code offre
				"libelleCs2" => ["value" => $codeOrigine, "matchMode" => "equals"]];  // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
	];
	$token = getToken(LOGIN,CREDENTIAL);

	print "Recherche des tarifs du code origine = ".$codeOrigine."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	


	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction du montant TTC avec un classement par ref_tarif
	$montantTTC = 110; 
	$filters = ["montantTtc" => ["value" => $montantTTC, "matchMode" => "equals"]];  // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 
	// Remarque pour un montant ht mettre : 'montantHt' (à la place de 'montantTtc')

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
	];
	$token = getToken(LOGIN,CREDENTIAL);

	print "Recherche des tarifs du montant TTC = ".$montantTTC."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);



	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction de différents criteres de recherche avec un classement par ref_tarif
	$montantTTC = 200;
	$origineAbonnement = 500;
	$codeOrigine = "CODEORIGINE";
	$codeTitre = "VAP";
	$filters = ["montantTtc" => ["value" => $montantTTC, "matchMode" => "equals"],
				"pc2.paramCs1.refCs" => ["value" => $origineAbonnement, "matchMode" => "equals"], 
				"libelleCs2" => ["value" => $codeOrigine, "matchMode" => "equals"],
				"refTitre.titreAbrege" => ["value" => $codeTitre, "matchMode" => "equals"] 
			];  

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
	];
	$token = getToken(LOGIN,CREDENTIAL);

	print "Recherche des tarifs de différents critères de recherche<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
?>
