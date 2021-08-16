<?php
	require_once("../resttbs.php");
	
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	// Liste des produits par catégories
	$refBoutique = 1; // OBLIGATOIRE (correspond à la référence boutique - mettre 1 lorsqu'il n'y a qu'une seule boutique gérée)
    $refCategorie = 1;

    $params = [
		"maxResults" => 10, // OBLIGATOIRE compris entre 1 et 100
        "refCategorie" => $refCategorie,
        "sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou décroissant (<=> -1) sur le sortField
        "sortField" => "codeSelectionShop.position" // permet de filtrer sur la position des produits au sein d'une catégorie
    ];

	print "Liste des produits de la catérorie $refCategorie <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/boutique/".$refBoutique."/produit", $token, $params);
?>