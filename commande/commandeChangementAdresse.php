<?php
	require_once("../resttbs.php");

	// CHANGEMENT D'ADRESSE DU CLIENT 
	// EXEMPLE DE COMMANDE AVEC LA REFADRESSE DU CLIENT

	// Creation du tampon client
	$commandeDuclient = [];
	// Le code client doit apartenir à un Tiers dans cas de livraison de type = 2
	$commandeDuclient["codeClient"] = 132448; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 0; //permet d'ecraser les donnees 'adresse' du client 
	
	 //référence de l'adresse du client qui sera modifiée par les champs d'adresse ci-dessous
	$commandeDuclient["refAdresse"] = 178521;
	// les champs 'adresse' ci-dessous sont obligatoire en cas de 
	// modification de donnée et pour ne pas perdre la donnée déjà existante
	$commandeDuclient["civilite"] = "M"; 
	$commandeDuclient["nom"] = "LE NOM MODIFIE"; 
	$commandeDuclient["prenom"] = "LE PRENOM MODIFIE"; 
	$commandeDuclient["societe"] = "SOCIETE MODIFIE"; 
	$commandeDuclient["titreAdresse"] = "TITRE ADRESSE MODIFIE"; 
	$commandeDuclient["adresse1"] = "ADRESSE 1 MODIFIE"; 
	$commandeDuclient["adresse2"] = "ADRESSE 2 MODIFIE"; 
	$commandeDuclient["adresse3"] = "ADRESSE 3 MODIFIE"; 
	$commandeDuclient["adresse4"] = "ADRESSE 4 MODIFIE"; 
	$commandeDuclient["cp"] = "99999"; 
	$commandeDuclient["ville"] = "VILLE MODIFIE"; 
	$commandeDuclient["email"] = "unemailMODIFIE@tbsblue.com"; 
	$commandeDuclient["telephone"] = "0101010101";
	$commandeDuclient["telecopie"] = "0123456789";
	$commandeDuclient["portable"] = "0123456789";
	$commandeDuclient["codeIso"] = "FR";
	$commandeDuclient["codePays"] = "XXXXX";
	$commandeDuclient["nomPays"] = "FRANCE";
	$commandeDuclient["pays"] = "FRANCE";
	$commandeDuclient["codeNii"] = "CODE NII";

	$commandeDuclient["refSociete"] = REF_SOCIETE; //OBLIGATOIRE identifiant de la societe
	

	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";


	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}
?>
