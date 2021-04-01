<?php
	require_once("../resttbs.php");
	
	// MISE A JOUR DE L'OPTIN
	$codeClient = 11000;
	
	$optinClient = [];
	$optinClient["refOptin"] = 5; //Référence obtenue par lecture du reférentiel d'optin : /editeur/rgpd
	$optinClient["value"] = true; //true ou false, valeur de l'optin
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Mise a jour d'un optin pour le client codeClient = ".$codeClient."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client/".$codeClient."/rgpd", $token, $optinClient);

?>
