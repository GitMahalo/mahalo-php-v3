<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	$codeClient = 1000;
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des codes de selections du client ".$codeClient."<br>";
	$params = [
			"crm" => 0, // 0 (default) ou 1 indique si le codeSelection fair partie de la liste CRM ou non ATTENTION a bien checker les deux valeurs
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/codeselection", $token, $params);

?>
