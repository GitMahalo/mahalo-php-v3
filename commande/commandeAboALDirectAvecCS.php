<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "132442"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	$commandeDuclient["noCommandeBoutique"] = "AZERTY4"; //optionnel - votre numero de commande boutique qui doit être unique si renseigné
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees client lors de la validation de la commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();


	$leCsAbonnement = [];
	$leCsAbonnement["refCs"] = 1005;
	$leCsAbonnement["libelle"] = "UNCSABO";

	$leCsFacture = [];
	$leCsFacture["refCs"] = 1004;
	$leCsFacture["libelle"] = "UNSCFACTURE";

	$leCsLigneFacture = [];
	$leCsLigneFacture["refCs"] = 1006;
	$leCsLigneFacture["libelle"] = "UNCSLIGNEFACTURE";

	//ajout des code de selection qui seront rattaches au futur client sur la structure tamponClient
	$codesSelection = [];
	$codesSelection[] = $leCsFacture; //ajout d'un CS sur la facture du client
	$commandeDuclient["codesSelection"] = $codesSelection;

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 43173; // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	//$ligneCommande0["montantTtc"] = 48; //le montant n'a pas d'importance car il ne peut pas etre force dans le cadre d'un abonnement
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$ligneCommande0["codesSelection"] = [];
	$ligneCommande0["codesSelection"][] = $leCsAbonnement; //CS sur l'abonnement
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//Creation d'une ligne de commande d'article libre
	$ligneCommande1["refTarif"] = 31052; // reference unique de l'article libre /* obligatoire */ obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande1["tauxRemise"] = 10; //taux de remise toujours en pourcentage /*optionnel*/
	//$ligneCommande1["montantTtc"] = 12; //le montant peut ete force, attention donc e passer le montant exact, sinon ne pas passer cette rubrique
	$ligneCommande1["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)

	$ligneCommande1["codesSelection"] = [];
	$ligneCommande1["codesSelection"][] = $leCsLigneFacture; //CS sur la ligne de facture
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;

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
