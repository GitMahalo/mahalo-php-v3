<?php
	require_once("../resttbs.php");
	
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	// Liste des catégories	
	$refBoutique = 1; // OBLIGATOIRE (correspond à la référence boutique - mettre 1 lorsqu'il n'y a qu'une seule boutique gérée)

    $params = [
		"maxResults" => 10 // OBLIGATOIRE compris entre 1 et 100
    ];

	print "Liste des produits<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/boutique/".$refBoutique."/produit", $token, $params);
?>