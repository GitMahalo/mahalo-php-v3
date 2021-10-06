<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Pour forcer la date de début de l'abonnement : dateDebutAbo

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "115466"; //codeClient - OBLIGATOIRE
	
	$commandeDuclient["nePasModifierClient"] = 1; // 1 = ne modifie pas les donnees client lors de la validation de la commande

	$commandeDuclient["refSociete"] = REF_SOCIETE; //OBLIGATOIRE identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 5332; // 5315 // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	// Obligatoire si on force la date du debut d'abonnement simple ou une formule en date à date et dans le cas ou ca n'est pas considéré comme un réabonnement. 
	$ligneCommande0["dateDebutAbo"] = "2021-08-01";  
	$ligneCommande0["typeAdresseLiv"] = 0; // adresse de livraison du 'codeClient'
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";


	if(VALIDATION_COMMANDE) {
		print "Validation de la commande";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}

?>
