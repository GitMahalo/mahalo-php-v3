<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE
	
	// Cr�ation du tampon client	
	$commandeDuclient = [];		
	$commandeDuclient["codeClient"] = 543283; //codeClient retourn� par l'api client get (lecture) si absent, le client sera cr�� lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas �craser les donn�es adresse client (� utiliser uniquement si le codeClient est pass� en param�tre)
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();
	
	//Cr�ation d'une ligne de commande d'abonnement pr�pay� (tarif d'abonnement gratuit dans Aboweb)
	$ligneCommande0["refTarif"] = 12; // r�f�rence unique de l'abonnement gratuit correspondant � 5euro de carte cadeau obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 2; //1 ch�que - 2 CB - 3 RIB (cr�ation de Mandat n�cessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (cr�ation de CB n�cessaire en amont)//2 CB 
	$ligneCommande0["typeAdresseLiv"] = 5; //Cr�ation d'une adresse temporaire utilis� uniquement pour la commande
	$ligneCommande0["civiliteLiv"] = 'M';
	$ligneCommande0["nomLiv"] = 'LABAS';
	$ligneCommande0["prenomLiv"] = 'LOIN';
	$ligneCommande0["adresse2Liv"] = '22 AV DE LA GARE';
	$ligneCommande0["cpLiv"] = '1000000';
	$ligneCommande0["villeLiv"] = 'PEKIN';
	$ligneCommande0["codeIsoPaysLiv"] = "CN";
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;

	$ligneCommande = array();
	$ligneCommande[0] = $ligneCommande0; 

	//TRAITEMENT DES CALL API
	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "R�ference de la commande = ".$response->value->noCommande."<br>";
	
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}
?>