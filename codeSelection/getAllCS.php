<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Client
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Lecture des codes de selections d'un éditeur<br>";
	$params = [
			"maxResults" => 100, // OBLIGATOIRE compris entre 1 et 100
			"sortOrder" => 1, // permet de trier par ordre croissant (<=> 1) ou décroissant (<=> -1) sur le sortField
			"sortField" => "libelleCs" // permet de filtrer sur libelle du CS
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/admin/codeselection", $token, $params);

?>
