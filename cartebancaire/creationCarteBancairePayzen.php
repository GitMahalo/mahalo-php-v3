<?php
	require_once("../resttbs.php");
	
	// CREATION D'UNE CARTE BANCAIRE	
	$cb = [];		
	$cb["token"] = '0d9cbbd7ff0a123456978af6b61bb122'; // token (obligatoire)
	$cb["dateVal"] = '2109'; // date d'expiration de la cb au format 'yyMM' (obligatoire pour les traitements de relance de CB expirés)
	$cb["firstNumbers"] = 1234; // optionnel - premiers chiffres d'une cb
	$cb["lastNumbers"] = 9876; // optionnel - derniers chiffres d'une cb
	$cb["titulaire"] = 'NOM PRENOM'; // optionnel - nom prenom du titulaire de la cb
	
	// cela permet de forcer le prestataire de paiement (la valeur refPrestataire est à adapter selon l'éditeur)
	// cette info n'est pas nécessaire dans la majorité des cas
	// optionnel : si refPrestaire non défini, le prestataire sera déduit de la configuration de la société
	//$cb["refPrestataire"] = 1;

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation d'une carte bancaire<br><br>";
	print "Donnees en entree de la nouvelle carte bancaire : <br>";
	print "Token = ".$cb["token"]."<br>";
	print "Date d'expiration de la cb a mettre au format 'yyMM'= ".$cb["dateVal"]."<br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $cb);
	
	print "refCarteBancaire de la nouvelle carte bancaire = ".$response->value->refCarteBancaire."<br><br>";
?>
