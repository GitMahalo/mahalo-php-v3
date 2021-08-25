<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL CS
	
	print "WS obsolète. Cf nouvel exemple d'appel WS : getAllCS.php<br>";

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	//Insertion de la commande
	print "Lecture des codes de selections non crm disponibles pour les clients<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/aidesaisie", $token);

?>
