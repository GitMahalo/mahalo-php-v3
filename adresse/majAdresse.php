<?php
	require_once("../resttbs.php");
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	
	// MODIFICATION D'UNE ADRESSE
	$refAdresse =  81480;
	
	$adresse = [];
	$adresse["refAdresse"] = $refAdresse; // OBLIGATOIRE
	$adresse["adresse2"] = "ADRESSE MAJ"; 
	$adresse["cp"] = "12345"; 
	$adresse["ville"] = "VILLE MAJ"; 
		

	print "Mise à jour d'une adresse non principale refAdresse = ".$refAdresse."<br>";
	$response = callApiPatch("/editeur/".REF_EDITEUR."/adresse/".$refAdresse, $token, $adresse);

	print "codeClient de l'adresse modifiée = ".$response->value->codeClient."<br><br>";

?>
