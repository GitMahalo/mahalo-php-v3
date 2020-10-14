<?php
	require_once("../resttbs.php");
	
	// CREATION D'UNE CARTE BANCAIRE	
	$cb = [];		
	$cb["token"] = 'SMLLwsqPLdt'; // token
	// $cb["cbCode"] = null; // pour une creation cb 
	$cb["dateVal"] = '2109'; // date d'expiration de la cb au format 'yyMM'
	$cb["firstNumbers"] = 1234; // premiers chiffres d'une cb
	$cb["lastNumbers"] = 9876; // derniers chiffres d'une cb
	$cb["titulaire"] = 'NOM PRENOM'; // nom prenom du titulaire de la cb
	$cb["refPrestataire"] = 1; // référence du prestataire de paiement

	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation d'une carte bancaire<br><br>";
	print "Données en entrée de la nouvelle carte bancaire : <br>";
	print "Token = ".$cb["token"]."<br>";
	// print "cbCode vaut null pour la création d'une nouvelle carte <br>";
	print "Date d'expiration de la cb à mettre au format 'yyMM' = ".$cb["dateVal"]."<br>";
	print "Premiers chiffres d'une cb (pas obligatoire) : ".$cb["firstNumbers"]."<br>";
	print "Derniers chiffres d'une cb (pas obligatoire) : ".$cb["lastNumbers"]."<br>";
	print "Référence du prestataire de paiement = ".$cb["refPrestataire"]."<br><br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $cb);
	
	print "cbCode de la nouvelle carte bancaire = ".$response->value->cbCode."<br><br>";
?>
