<?php
////////////////////////////////////////////////////////////////////
///////// COMMANDE MULTIBENEFICIAIRES TIERS PAYANT ONE SHOOT CB /////
////////////////////////////////////////////////////////////////////

	require_once("../resttbs.php");

	// CREATION DU TIERS PAYANT
	$clientTP = [];
	$clientTP["email"] = 'lenouveautierspayant@email.fr';
	$clientTP["typeClient"] = 1; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	$clientTP["origineAbm"] = "ABM"; //Origine du client
	$clientTP["civilite"] = 'M';
	$clientTP["nom"] = 'LE TIERS';
	$clientTP["prenom"] = 'LE TIERS';
	$clientTP["societe"] = 'TP';
	$clientTP["adresse1"] = '';
	$clientTP["adresse2"] = '24 RUE DES FLEURS';
	$clientTP["adresse3"] = '';
	$clientTP["cp"] = '92100';
	$clientTP["ville"] = 'BOULOGNE BILLANCOURT';
	$clientTP["motPasseAbm"] = 'LEMOTDEPASSE';
	$clientTP["codeIsoPays"] = "FR";

	// CREATION DES BENEFICIARES

	// BENEFICIAIRE 1
	$clientPP1 = [];
	$clientPP1["email"] = 'lenouveaupayepar1@email.fr';
	$clientPP1["typeClient"] = 2; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	//$clientPP1["codeTiers"] = XXXX; //code du tiers precedement cree ou identifie, obligatoire si type client = 2
	$clientPP1["origineAbm"] = "ABM"; //Origine du client
	$clientPP1["civilite"] = 'M';
	$clientPP1["nom"] = 'LE PP1';
	$clientPP1["prenom"] = 'LE PP1';
	$clientPP1["societe"] = 'PP1';
	$clientPP1["adresse1"] = '';
	$clientPP1["adresse2"] = '1 RUE DES ARBRES';
	$clientPP1["adresse3"] = '';
	$clientPP1["cp"] = '75017';
	$clientPP1["ville"] = 'PARIS';
	$clientPP1["motPasseAbm"] = 'LEMOTDEPASSEPP1';
	$clientPP1["codeIsoPays"] = "FR";

	//BENEFICIAIRE 2
	$clientPP2 = [];
	$clientPP2["email"] = 'lenouveaupayepar2@email.fr';
	$clientPP2["typeClient"] = 2; //type de client (0 = normal, 1 = Tiers, 2 = Paye Par)
	//$clientPP2["codeTiers"] = XXXX; //code du tiers precedement cree ou identifie, obligatoire si type client = 2
	$clientPP2["origineAbm"] = "ABM"; //Origine du client
	$clientPP2["civilite"] = 'M';
	$clientPP2["nom"] = 'LE PP2';
	$clientPP2["prenom"] = 'LE PP2';
	$clientPP2["societe"] = 'PP2';
	$clientPP2["adresse1"] = '';
	$clientPP2["adresse2"] = '2 RUE DES ARBRES';
	$clientPP2["adresse3"] = '';
	$clientPP2["cp"] = '75017';
	$clientPP2["ville"] = 'PARIS';
	$clientPP2["motPasseAbm"] = 'LEMOTDEPASSEPP2';
	$clientPP2["codeIsoPays"] = "FR";

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	//$commandeDuclient["codeClient"] = XXXX; //codeClient du tiers
	//passer eventuellement les infos clients - optionnel si nePasModifierClient = 1
	$commandeDuclient["nom"] = 'LE TIERS';
	$commandeDuclient["prenom"] = 'LE TIERS';
	$commandeDuclient["email"] = 'lenouveautierspayant@email.fr';
	$commandeDuclient["nePasModifierClient"] = 1; //si 0 il faut envoyer tous les elements d'adresses, si 1 -> les elements d'adresses sont optionnels
	$commandeDuclient["noCommandeBoutique"] = "HYIUN45IJ"; //on peut passer ici une reference personnalisee de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande pour chaque beneficiaire
	$ligneCommande0["refTarif"] = 10; // Reference interne du tarif obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 7; //la ligne de commande est affectee au paye Par identifie par le codeClientLiv
	//$ligneCommande0["codeClientLiv"] = XXXX; //codeClient du beneficiaire 1
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	$ligneCommande1["codeTarif"] = 11; // Reference interne du tarif obtenu par l'api tarif
	$ligneCommande1["quantite"] = 1;
	$ligneCommande1["modePaiement"] = 2; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande1["typeAdresseLiv"] = 7; //la ligne de commande est affectee au paye Par identifie par le codeClientLiv
	//$ligneCommande1["codeClientLiv"] = XXXX; //codeClient du beneficiaire 2
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	print "Creation du tiers<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $clientTP);

	print "codeClient du tiers = ".$response->value->codeClient."<br><br>";

	$commandeDuclient["codeClient"] = $response->value->codeClient;
	$clientPP1["codeTiers"] = $response->value->codeClient;
	$clientPP2["codeTiers"] = $response->value->codeClient;

	
	print "Creation du beneficiaire 1<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $clientTP);

	print "codeClient du beneficiaire 1 = ".$response->value->codeClient."<br><br>";
	$ligneCommande0["codeClientLiv"] = $response->value->codeClient;


	print "Creation du beneficiaire 2<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/client", $token, $clientTP);

	print "codeClient du beneficiaire 2 = ".$response->value->codeClient."<br><br>";
	$ligneCommande1["codeClientLiv"] = $response->value->codeClient;

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
