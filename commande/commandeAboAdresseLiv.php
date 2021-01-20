<?php
	require_once("../resttbs.php");

	//PREPARATION DE LA COMMANDE

	// Exemples de commande avec différentes adresses de livraison
	// typeAdresseLiv : paramètre qui va gérer selon sa valeur 
	// 0 : adresse de livraison du 'codeClient'
	// 2 : nouvelle adresse de livraison avec création d'un nouveau client
	// 5 : nouvelle adresse temporaire de livraison sans création d'un nouveau client
	// 7 : adresse de livraison du beneficiaire identifie par le 'codeClientLiv'

	// Creation du tampon client
	$commandeDuclient = [];
	// Le code client doit apartenir à un Tiers dans cas de livraison de type = 2
	$commandeDuclient["codeClient"] = 2023952; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client
	$commandeDuclient["refSociete"] = REF_SOCIETE; //OBLIGATOIRE identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	// Creation d'une ligne de commande d'abonnement pour une adresse
	// Avec création d'un nouveau bénéficiaire à chaque fois
	$ligneCommande0["refTarif"] = 1153; // reference unique de l'abonnement obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande0["typeAdresseLiv"] = 2; // pour gerer une nouvelle adresse de livraison au nouveau client bénéficiaire
	// Adresse du nouveau client a livrer avec creation du client
	$ligneCommande0["civiliteLiv"] = 'M';
	$ligneCommande0["nomLiv"] = 'LABAS1';
	$ligneCommande0["prenomLiv"] = 'LOIN1';
	$ligneCommande0["adresse2Liv"] = '22 AV DE LA GARE 1';
	$ligneCommande0["cpLiv"] = '35000';
	$ligneCommande0["villeLiv"] = 'VILLELIV1';
	$ligneCommande0["codeIsoPaysLiv"] = "FR";
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;
	
	// Creation d'une ligne de commande d'abonnement pour un codeClient en particulier
	// Dans le cas où le bénéficiaire existe déjà
	$ligneCommande1["refTarif"] = 1131; // reference unique de l'abonnement obtenu par l'api tarif
	$ligneCommande1["quantite"] = 2; // nombre d'exemplaire
	$ligneCommande1["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande1["typeAdresseLiv"] = 7; //la ligne de commande est affectee au beneficiaire identifie par le codeClientLiv
	$ligneCommande1["codeClientLiv"] = 2023969; //codeClient du beneficiaire 
	$commandeDuclient["lignesCommande"][] = $ligneCommande1;
	
	// Creation d'une ligne de commande d'abonnement pour le client
	// A livrer chez le client directement
	$ligneCommande2["refTarif"] = 1132; // reference unique de l'abonnement obtenu par l'api tarif
	$ligneCommande2["quantite"] = 1;
	$ligneCommande2["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande2["typeAdresseLiv"] =  0; //pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["lignesCommande"][] = $ligneCommande2;
	
	// Creation d'une ligne de commande d'abonnement pour une adresse temporaire
	$ligneCommande3["refTarif"] = 1153; // reference unique de l'abonnement obtenu par l'api tarif
	$ligneCommande3["quantite"] = 5;
	$ligneCommande3["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)//2 CB
	$ligneCommande3["typeAdresseLiv"] = 5; // pour gerer une nouvelle adresse de livraison temporaire
	// Adresse temporaire a livrer sans creation du client
	$ligneCommande3["civiliteLiv"] = 'M';
	$ligneCommande3["nomLiv"] = 'NOM TEMPORAIRE';
	$ligneCommande3["prenomLiv"] = 'PRENOM TEMPORAIRE';
	$ligneCommande3["adresse2Liv"] = 'RUE TEMPORAIRE';
	$ligneCommande3["cpLiv"] = '35000';
	$ligneCommande3["villeLiv"] = 'VILTEMP';
	$ligneCommande3["codeIsoPaysLiv"] = "FR";
	$commandeDuclient["lignesCommande"][] = $ligneCommande3;
	
	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);
	
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
