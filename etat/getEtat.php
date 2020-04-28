<?php
	require_once("../resttbs.php");
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Lecture des etats disponibles<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/etat", $token);

?>
