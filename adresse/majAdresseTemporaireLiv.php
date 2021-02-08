<?php
	require_once("../resttbs.php");
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	
	// Exemple détaillé de modification d'une adresse temporaire crée via une commande WS avec le typeAdresseLiv = 5
	

	$codeClient = 2023969;

	// Creation de la commande
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = $codeClient; //codeClient
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client
	$commandeDuclient["refSociete"] = REF_SOCIETE; //OBLIGATOIRE identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	// Creation d'une ligne de commande d'abonnement pour une adresse temporaire "typeAdresseLiv" = 5
	$ligneCommande["refTarif"] = 1157; // reference unique de l'abonnement obtenu par l'api tarif
	$ligneCommande["quantite"] = 1;
	$ligneCommande["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande["typeAdresseLiv"] = 5; // pour gerer une nouvelle adresse de livraison temporaire
	// Adresse temporaire a livrer sans creation du client
	$ligneCommande["civiliteLiv"] = 'M';
	$ligneCommande["nomLiv"] = 'NOM TEMPORAIRE';
	$ligneCommande["prenomLiv"] = 'PRENOM TEMPORAIRE';
	$ligneCommande["adresse2Liv"] = 'RUE TEMPORAIRE';
	$ligneCommande["cpLiv"] = '35000';
	$ligneCommande["villeLiv"] = 'VILTEMP';
	$ligneCommande["codeIsoPaysLiv"] = "FR";
	$commandeDuclient["lignesCommande"][] = $ligneCommande;

	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";

	// Validation automatique de la commande (peut se faire via l'ihm)
	print "Validation automatique de la commande<br>";
	$commandes = [];
	$commandes[] = $response->value->noCommande;
	$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);

	// liste des abonnements en fonction du numéro de commande
	$noCommande = "$commandes[0]";
	$filters = ["noCommande" => ["value" => $noCommande, "matchMode" => "equals"]]; 
	$params = [
			"maxResults" => 10, // champs obligatoire compris entre 1 et 100
			"filters" => json_encode($filters),
			"sortOrder" => -1, // permet de trier par ordre croissant (<=> 1) ou decroissant (<=> -1) sur le sortField
			"sortField" => "dateFinAbonnement" // permet de filtrer sur la colonne dateFin
	];
	
	print "Recupere tous les abonnements de la commande = ".$noCommande."<br><br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);

	// Récupération de l'adresse a modifier
	$adresses = [];
	$adresses[] = $response->value[0]->refAdresseLivraison;
	$refAdresse =  $adresses[0];
	
	
	// Lecture de l'adresse avant modification
	print "Lecture de l'adresse = ".$refAdresse."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/adresse/".$refAdresse, $token);
	
	
	// Modification de l'adresse de livraison temporaire
	$adresse = [];
	$adresse["refAdresse"] = $refAdresse; // OBLIGATOIRE
	$adresse["adresse2"] = "ADRESSE MAJ"; 
	$adresse["cp"] = "12345"; 
	$adresse["ville"] = "VILLE MAJ"; 

	print "Mise à jour d'une adresse refAdresse = ".$refAdresse."<br>";
	$response = callApiPatch("/editeur/".REF_EDITEUR."/adresse/".$refAdresse, $token, $adresse);

	print "codeClient de l'adresse modifiée = ".$response->value->codeClient."<br><br>";

	// Lecture de l'adresse après modification
	print "Lecture de l'adresse = ".$refAdresse."<br>";
	$response = callApiGet("/editeur/".REF_EDITEUR."/adresse/".$refAdresse, $token);

?>
