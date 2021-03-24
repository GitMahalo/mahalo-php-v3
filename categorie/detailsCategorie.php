<?php
	require_once("../resttbs.php");
	
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	// Détails d'une catégorie	
	$refCategorie = 21;
	$refBoutique = 1;

	print "Détails d'une catégorie = ".$refCategorie." <br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/boutique/".$refBoutique."/categorie/".$refCategorie, $token);
?>
