<?php
	require_once("../resttbs.php");
	
	// Suppression d'une suspension temporaire d'un abonnement
	$refSuspension = 10; // reference suspension
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suppression d'une suspension temporaire d'un abonnement : ".$refAbonnement."<br><br>";
	$response = callApiDelete("/editeur/".REF_EDITEUR."/suspension/".$refMotifSuspension, $token, null);

?>
