<?php
	require_once("../resttbs.php");
	
	// MAJ D'UNE CARTE BANCAIRE
	$cb = [];		
	$cb["token"] = 'SMLLwsqPLdt'; // token
	// exemple de token pour une CB SLIMPAY : 'SMLLwsqPLdt'
	// exemple de token pour une CB STRIPE (customer Stripe) : 'cus_HgjUPRlzIryloH'
	$cb["cbCode"] = 'PBX38687'; // obligatoire pour maj de la cb 
	$cb["dateVal"] = '2110'; // date d'expiration de la cb au format 'yyMM'
	$cb["firstNumbers"] = 1234; // premiers chiffres d'une cb - Optionnel
	$cb["lastNumbers"] = 9876; // derniers chiffres d'une cb - Optionnel
	$cb["titulaire"] = 'NOM PRENOM'; // nom prenom du titulaire de la cb
	//$cb["refPrestataire"] = 1; // reference du prestataire de paiement (la valeur refPrestataire est à adapter selon l'éditeur), optionnel si non défini, le prestataire sera déduit de la configuration de la société

	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Mise � jour d'une carte bancaire<br><br>";
	
	print "Remarque, la mise � jour d'une carte bancaire se fait sur la valeur : cbCode<br><br>";
	
	print "Donn�es en entr�e de la nouvelle carte bancaire : <br>";
	print "Token = ".$cb["token"]."<br>";
	print "cbCode = ".$cb["cbCode"]."<br>";
	print "Date d'expiration de la cb � mettre au format 'yyMM' = ".$cb["dateVal"]."<br>";
	// print "Premiers chiffres d'une cb (pas obligatoire) : ".$cb["firstNumbers"]."<br>";
	// print "Derniers chiffres d'une cb (pas obligatoire) : ".$cb["lastNumbers"]."<br>";
	print "R�f�rence du prestataire de paiement = ".$cb["refPrestataire"]."<br><br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $cb);
	
	print "refCb de la carte bancaire mise � jour = ".$response->value->refCb."<br><br>";
?>
