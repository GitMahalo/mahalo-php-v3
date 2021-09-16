<?php
	require_once("../resttbs.php");

	//VALIDATION EN MASSE DE COMMANDES
	


	$token = getToken(LOGIN,CREDENTIAL);
	
	$commandes = [];
	$commandes = array(aaa, xxx, zzz); // aaa, xxx, zzz : correspondent à différentes ref_action à valider

	$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
?>
