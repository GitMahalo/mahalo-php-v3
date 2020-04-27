<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 1000;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Lecture des codes de selections disponibles pour les clients<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/aidesaisie", $token);

?>
