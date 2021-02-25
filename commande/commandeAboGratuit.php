<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "132436"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	
	// 0 : permet de modifier les donnees client lors de la validation de la commande 
	// Alors les champs adresse ci-dessous sont obligatoire en cas de 
	// modification de donnée et pour ne pas perdre la donnée déjà existante
	// 1 : ne modifie pas les donnees du client lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; 

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'une formule gratuite
	$ligneCommande0["refTarif"] = 43182; // reference unique d'une formule gratuite /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;


	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
