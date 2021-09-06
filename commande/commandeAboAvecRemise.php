<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Dans tous les cas si la rubrique "tauxRemise" est alimentée dans la commande, on applique la remise

	// clé système dans le cas d'un réabonnement : COMMANDES_REMISE_REABONNEMENT : 
	// TRUE : reconduire uniquement la remise du précédent abonnement
	// FALSE : (par défaut) Aucune remise n'est reconduite, même si le client bénéficie d'une remise client
	// Lors d'une commande d'ABONNEMENT, la remise client n'est pas utilisée.

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "407044"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	$commandeDuclient["nePasModifierClient"] = 1; // 1 : ne modifie pas les donnees du client lors de la validation de la commande
	// $commandeDuclient["noCommandeBoutique"] = "XXXXX";
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'une formule ''
	$ligneCommande0["refTarif"] = 2443; // reference unique d'une formule /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["tauxRemise"] = 10; // taux de remise
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;
	

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
