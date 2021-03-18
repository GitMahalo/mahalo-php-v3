<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Pour forcer le pns en abonnement : WS_FORCE_DEBUT_ABO = T

    $noCommandeBoutique="MONNUMEROBOUTIQUE";

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = "132444"; //codeClient retourne par l'api client get (lecture) ou post (creation)
	
	$commandeDuclient["nePasModifierClient"] = 1; // 0 = permet de modifier les donnees client lors de la validation de la commande
	$commandeDuclient["noCommandeBoutique"] = $noCommandeBoutique; //optionnel - votre numero de commande boutique
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 43182; // reference unique du tarif d'abonnement /* obligatoire */ obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	// INSERTION DE LA COMMANDE
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br><br>";


    //RECHERCHE AVEC NOCOMMANDEBOUTIQUE EN MODE EQUALS
	$filters =  [ "noCommandeBoutique" => [
			"value" =>  $noCommandeBoutique,
			"matchMode"=> "equals"
			]
		];
	
	$params["filters"] = json_encode($filters);
	print "Nombre de commande ayant noCommandeBoutique = ".$noCommandeBoutique."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/commande/count", $token, $params);
	
	print "Recherche de la commande ayant noCommandeBoutique = ".$noCommandeBoutique."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/commande", $token, $params);

	//VALIDATION DE LA COMMANDE ASSOCIEE
	print "Validation d'une commande qui renvoie une erreur si le codeClient n'existe pas<br><br>";
	$commandes = [];
	$commandes[] = $response->value[0]->noCommande;
	$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);

?>
