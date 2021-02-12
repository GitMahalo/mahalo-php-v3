<?php
	require_once("../resttbs.php");
	
	// CREATION D'UNE CARTE BANCAIRE COTE ABOWEB 
    // AVEC UNE PRISE D'EMPRUNTE DEJA EXISTANTE DANS PAYBOX	

    // Cas où l'appelant a déjà créé une prise d'emprunte dans Paybox et où ensuite on ajoute cette CB dans Aboweb

    // CHAMPS OBLIGATOIRE : TOKEN, DATEVAL, CBCODE

	$cb = [];		
	$cb["token"] = 'SMLLwsqPLdt'; // token (obligatoire)
	$cb["cbCode"] = 'refAbonnePaybox'; // correspond à la ref abonné de Paybox 
	$cb["dateVal"] = '2109'; // date d'expiration de la cb au format 'yyMM' (obligatoire pour les traitements de relance de CB expirés)
	$cb["firstNumbers"] = 1234; // premiers chiffres d'une cb
	$cb["lastNumbers"] = 9876; // derniers chiffres d'une cb
	$cb["titulaire"] = 'NOM PRENOM'; // nom prenom du titulaire de la cb
	$cb["refPrestataire"] = 1; // reference du prestataire de paiement

	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation d'une carte bancaire<br><br>";
	print "Donnees en entree de la nouvelle carte bancaire : <br>";
	print "Token = ".$cb["token"]."<br>";
	print "cbCode = ".$cb["cbCode"]."<br>";
	print "Date d'expiration de la cb a mettre au format 'yyMM'= ".$cb["dateVal"]."<br>";
	print "Premiers chiffres d'une cb : ".$cb["firstNumbers"]."<br>";
	print "Derniers chiffres d'une cb : ".$cb["lastNumbers"]."<br>";
	print "Reference du prestataire de paiement  = ".$cb["refPrestataire"]."<br><br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $cb);
	
	print "refCb de la nouvelle carte bancaire = ".$response->value->refCb."<br><br>";
?>
