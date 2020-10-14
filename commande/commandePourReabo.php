<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 4797534; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas ecraser les donnees adresse client (a utiliser uniquement si le codeClient est passe en parametre)
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement a reabonner 
	$ligneCommande0["refTarif"] = 20708; 
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 1; //1 cheque - 2 CB - 3 RIB (creation de Mandat necessaire en amont) - 4 Virement - 5 Paypal - 6 Prelevement CB (creation de CB necessaire en amont)
	$ligneCommande0["codeClientLiv"] = 4998122;
	$ligneCommande0["typeAdresseLiv"] = 7; // Gestion des tiers/beneficiaires
	$ligneCommande0["civiliteLiv"] = 'M';
	$ligneCommande0["nomLiv"] = 'GENDRIN';
	$ligneCommande0["prenomLiv"] = 'ERIC';
	$ligneCommande0["adresse2Liv"] = '4 IMPASSE DES WEIGELIAS';
	$ligneCommande0["cpLiv"] = '78700';
	$ligneCommande0["villeLiv"] = 'CONFLANS STE HONORINE';
	$ligneCommande0["codeIsoPaysLiv"] = "FR";
	$ligneCommande0["refAboEchu"] = 2375936; // permet de faire un reabonnement (au lieu d'un abonnement)
	
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	$ligneCommande = array();
	$ligneCommande[0] = $ligneCommande0;
	
	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	print "Reference de la commande = ".$response->value->noCommande."<br>";
	
?>