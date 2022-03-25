<?php
	require_once("../resttbs.php");
	
	// Suspension d'un client	
	$codeClient = 236; // code client
	//La liste des motifs de suspensions est disponible via l'exemple listeMotifsSuspensions.php
	//ATTENTION, pour appliquer une suspension sur un client, il faut que celle-ci possède la propriété suspendreClient à true
	$refMotifSuspension = x; // reference motif suspension
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
