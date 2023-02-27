<?php
	require_once("../resttbs.php");
	$refSociete = 1;
	$codeClient = 753208;
	
	//EXEMPLE CREATION D'UN MANDAT
	$mandat = [];
	//MANDAT SLIMPAY
	$mandat["tokenSepa"] = 'SLMP04038XXXX'; // token (obligatoire)
	/*MANDAT PAYZEN
		"tokenSepa" = "id" retournée par Payzen lors de la création du mandat, elle correspond à la concaténation de l'ID SITE et de la RUM. 
		Exemple : https://payzen.io/fr-FR/webservices-payment/web-service-sepa/consulter-les-donnees-du-mandat.html
	*/
	//$mandat["tokenSepa"] = '12341243-39a4b788ae9a401fba047ddxxxxxxxxx'; // token (obligatoire)
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
