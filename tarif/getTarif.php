<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Tarif
	
	$refTarif = 10;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture du tarif refTarif = ".$refTarif."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif/".$refTarif, $token);
	
	print "Recherche du premier tarif de type Article Libre<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token);
	
	print "Recherche de la premier Formule<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token);
	
	print "Recherche du premier tarif d'Abonnement<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/tarif", $token);

?>
