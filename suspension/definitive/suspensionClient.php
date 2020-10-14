<?php
	require_once("../resttbs.php");
	
	// Suspension d'un client	
	$codeClient = 236; // code client
	$refMotifSuspension = 1; // reference motif suspension
	$reactiverMauvaisPayeur = false; // mauvais payeur
	
	
	$params = [];
	
	$paramsQuery = [
			"codeClient" => $codeClient,// obligatoire
			"refMotifSuspension" => $refMotifSuspension,// obligatoire 
			"reactiverMauvaisPayeur" => $reactiverMauvaisPayeur // non obligatoire (true ou false)
	];
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Suspension du client : ".$codeClient."<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspendre/client", $token, $params, $paramsQuery);

?>
