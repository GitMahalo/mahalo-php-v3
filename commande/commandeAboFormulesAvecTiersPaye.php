<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "2490970"; //obligatoire codeClient du tiers retourne par l'api client get (lecture) ou post (creation)
	
	// 0 : permet de modifier les donnees client lors de la validation de la commande 
	// Alors les champs 'adresse' sont obligatoire en cas de 
	// modification de donnée et pour ne pas perdre la donnée déjà existante
	// 1 : ne modifie pas les donnees du client lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; 

	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'une formule ''
	$ligneCommande0["refTarif"] = 40070; // reference unique d'une formule /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 7; //pour gerer d'adresse de livraison au payé
	$ligneCommande0["codeClientLiv"] = "2490972"; // codeClient du payé
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;
	
	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	//Insertion de la commande
	print "Insertion de la commande<br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

?>
