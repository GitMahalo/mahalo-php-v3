<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 5116142;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture du client codeClient = ".$codeClient."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/client/".$codeClient, $token);

	$refCB = $response->value->refCb;

	// On retrouve toutes les données de la carte bancaire au niveau du client :
	// refCb / cbTitulaire / cbIdPsp / cbCode / cbNumero / cbExpire / cbCreation / cbRefPrestataire / cbPrestataire
	print "Reference de la carte bancaire = ".$refCB."<br><br>";

?>
