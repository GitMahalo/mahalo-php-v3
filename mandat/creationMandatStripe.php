<?php
	require_once("../resttbs.php");
	$refSociete = 1;
	$codeClient = 753208;
	
	//EXEMPLE CREATION D'UN MANDAT SLIMPAY
  	//Le prestataire de paiement configuré par défaut sur la société refSociete pour les paiements SEPA doit-être SLIMPAY
	$mandat = [];
	$mandat["tokenSepa"] = 'SLMP04038XXXX'; // token (obligatoire)
	$mandat["refSociete"] = $refSociete; // refSociete (obligatoire si plusieurs sociétés)
	$mandat["codeClient"] = $codeClient; // codeClient (obligatoire)

	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Creation dun mandat<br><br>";
	print "Donnees en entree du nouveau mandat : <br>";
	print "Token = ".$mandat["tokenSepa"]."<br>";
	print "refSociete = ".$mandat["refSociete"]."<br>";
	print "codeClient = ".$mandat["codeClient"]."<br>";
	
	$response = callApiPost("/editeur/".REF_EDITEUR."/mandat", $token, $mandat);
?>
