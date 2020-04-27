<?php
	require_once("../resttbs.php");

	///////// COMMANDE SIMPLE PAIEMENT STRIPE ABONNEMENT ADL /////

	/*Apr�s retour STRIPE pour cr�ation CB - envoyer le TOKEN � ABOWEB pour cr�ation CB dans Aboweb*/
	/*le premier pr�l�vement ne doit pas être �x�cut� par STRIPE mais par Aboweb. Stripe ne doit faiure qu'un empreinte de la CB */

	//PREPARATION DE LA CB
	
	$laCb=[];
	//Le prestaire de paiement CB est selectionne automatiquement en fonction du parametrage dans Aboweb
	$laCb["refSociete"] = REF_SOCIETE;
	$laCb["cbCode"] = "STR02";
	$laCb["token"] = "TEST_TOKEN01";//TOKEN retourn� par Stripe lors de la capture de CB
	$laCb["dateVal"] = "1910";
	$laCb["number"] = "1664";
	
	//PREPARATION DE LA COMMANDE
	
	// Cr�ation du tampon client			
	$commandeDuclient["codeClient"] = 000;  //codeClient retourn� par l'api client get (lecture) si absent, le client sera cr�� lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //permet de ne pas �craser les donn�es adresse client (� utiliser uniquement si le codeClient est pass� en param�tre)
	$commandeDuclient["noCommandeBoutique"] = "HYIUN45IJ"; //on peut passer ici une r�f�rence personnalis�e de commande
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["ligneCommande"] = array();
		
	//Cr�ation d'une ligne de commande d'abonnement
	$ligneCommande0["refTarif"] = 12; // r�f�rence unique de l'abonnement ADL obtenu par l'api tarif
	$ligneCommande0["quantite"] = 1;  
	$ligneCommande0["modePaiement"] = 6; //6 pour pr�l�vement sur CB. La commande sera int�gr�e avec g�n�ration d'une facture non sold�e et X pr�l�vements en fonction des param�trages du tarif
	$ligneCommande0["typeAdresseLiv"] = 0; //pour ne pas g�rer d'adresse de livraison (l'adresse de livraison est g�r�e via la nouvelle API createOrUpdateAdresse)
	$commandeDuclient["ligneCommande"][] = $ligneCommande0;
		
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	print "Creation de la cb ".$laCb["cbCode"]."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/cartebancaire", $token, $laCb);
	print "R�ference interne de la CB = ".$response->value->refCb."<br>";
	$commandeDuclient["refCarteBancaire"] = $response->value->refCb;
	
	//Insertion de la commande
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
	
	print "<br><br>R�ference de la commande = ".$response->value->noCommande."<br>";
	
	if(VALIDATION_COMMANDE) {
		print "Validation de la commande<br>";
		$commandes = [];
		$commandes[] = $response->value->noCommande;
		$response = callApiPut("/editeur/".REF_EDITEUR."/commande/validate", $token, $commandes);
	}
?>