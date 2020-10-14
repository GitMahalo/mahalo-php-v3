<?php
	require_once("../resttbs.php");
	
	// MAJ D'UNE CARTE BANCAIRE	
	$cb = [];		
	$cb["token"] = 'SMLLwsqPLdt'; // token
	$cb["cbCode"] = 'PBX38687'; // maj de la cb 
	$cb["dateVal"] = '2110'; // date d'expiration de la cb au format 'yyMM'
	// $cb["firstNumbers"] = null; // premiers chiffres d'une cb
	// $cb["lastNumbers"] = null; // derniers chiffres d'une cb
	$cb["titulaire"] = 'NOM PRENOM'; // nom prenom du titulaire de la cb
	$cb["refPrestataire"] = 1; // référence du prestataire de paiement

	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Mise à jour d'une carte bancaire<br><br>";
	
	print "Remarque, la mise à jour d'une carte bancaire se fait sur la valeur : cbCode<br><br>";
	
	print "Données en entrée de la nouvelle carte bancaire : <br>";
	print "Token = ".$cb["token"]."<br>";
	print "cbCode = ".$cb["cbCode"]."<br>";
	print "Date d'expiration de la cb à mettre au format 'yyMM' = ".$cb["dateVal"]."<br>";
	// print "Premiers chiffres d'une cb (pas obligatoire) : ".$cb["firstNumbers"]."<br>";
	// print "Derniers chiffres d'une cb (pas obligatoire) : ".$cb["lastNumbers"]."<br>";
	print "Référence du prestataire de paiement = ".$cb["refPrestataire"]."<br><br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $cb);
	
	print "refCb de la carte bancaire mise à jour = ".$response->value->refCb."<br><br>";
?>
