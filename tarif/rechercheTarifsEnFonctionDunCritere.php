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
	
	

	//RECHERCHE AVEC codeTarif en mode startsWith
	$params = [
		"maxResults" => 2, // champs obligatoire compris entre 1 et 100
		"offset" => 0,
		"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
		"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];
	$codeTarif = "FOR-";

	$filters =  [ "codeTarif" => [
			"value" =>  $codeTarif,
			"matchMode"=> "startsWith"
		]
	];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de tarif commencant par ".$codeTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Recherche des tarifs commencant par ".$codeTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	
	
	
	//RECHERCHE AVEC refTitre =  1 en mode equals
	$filters = ["refTitre" => ["value" => 1, "matchMode" => "equals"]]; // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 
	
	$params = [
		"maxResults" => 2, // champs obligatoire compris entre 1 et 100
		"filters" => json_encode($filters)
	];

	print "Nombre de tarif dont le refTitre = 1<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);
	
	print "Recherche des tarifs dont le refTitre = 1<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);
	


	//LECTURE DU REFERENTIEL pour recupere les tarifs en fonction du montant TTC avec un classement par ref_tarif
	$montantTTC = 200; 
	$filters = ["montantTtc" => ["value" => $montantTTC, "matchMode" => "equals"]];  // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 
	// Remarque pour un montant ht mettre : 'montantHt' (à la place de 'montantTtc')

	$params = [
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne
	];
	
	print "Nombre des tarifs du montant TTC = ".$montantTTC."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);

	print "Recherche des tarifs du montant TTC = ".$montantTTC."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);



	//LECTURE DU REFERENTIEL codeTitre <=> titre abrégé avec un classement par ref_tarif
	$codeTitre = "SAJ";
	$filters = ["refTitre.titreAbrege" => ["value" => $codeTitre, "matchMode" => "equals"]]; // "matchMode" permet de filtrer sur une donnee de facon strict ou non ("equals"/"contains"/"startsWith") 

	$params = [
			"maxResults" => 2, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "refTarif" // permet de filtrer sur la colonne refTarif
	];

	print "Nombre des tarifs du code titre = ".$codeTitre."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/count", $token, $params);

	print "Recherche des tarifs du code titre = ".$codeTitre."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token, $params);

?>
