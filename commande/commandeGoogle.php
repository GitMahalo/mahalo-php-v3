<?php
	require_once("../resttbs.php");
	
	//PREPARATION DE LA COMMANDE

    $numTransactionGoogle = "XXXXX"; //Identifiant unique de la commande pour pouvoir la retrouver ensuite

	// Creation du tampon client
	$commandeDuclient = [];
	$commandeDuclient["codeClient"] = 2171823; //codeClient retourne par l'api client get (lecture) si absent, le client sera cree lors de la validation de la commande
	$commandeDuclient["nePasModifierClient"] = 1; //Obligatoire permet de ne pas ecraser les donnees adresse client (a utiliser uniquement si le codeClient est passe en parametre)
	$commandeDuclient["refSociete"] = REF_SOCIETE; //Obligatoire identifiant de la societe
	$commandeDuclient["lignesCommande"] = array();

	//Creation d'une ligne de commande d'abonnement a reabonner 
	$ligneCommande0["refTarif"] = 39791; 
	$ligneCommande0["quantite"] = 1;
	$ligneCommande0["modePaiement"] = 8; //Mode de paiement Google
	//Attention suivant votre configuration, il faudra soit renseigner cs9 soit cs10 pour flagguer l'origine de l'abonnement
	$ligneCommande0["cs10"] = "GOOGLE"; // Ou $ligneCommande0["cs9"] = "GOOGLE";
	$ligneCommande0["typeAdresseLiv"] = 0; //Obligatoire pour ne pas gerer d'adresse de livraison (l'adresse de livraison est geree via la nouvelle API createOrUpdateAdresse)
	
	$commandeDuclient["lignesCommande"][] = $ligneCommande0;

	$ligneCommande = array();
	$ligneCommande[0] = $ligneCommande0;
	
	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);
	
	print "Insertion de la commande<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande", $token, $commandeDuclient);
    if (property_exists($response, 'value')) {
        $noCommande = $response->value->noCommande;

        print "Reference de la commande = $noCommande<br>";

        print "Validation de la commande $noCommande<br><br>";
        $commandes = [];
        $commandes[] = $noCommande;
        $response = callApiPut("/editeur/" . REF_EDITEUR . "/commande/validate", $token, $commandes);

        //Recherche du reglement correspondant à la commande
        if (property_exists($response, 'value')) {
            $validationCommandes = $response->value;
            foreach ($validationCommandes as $validationCommande) {
                if($validationCommande->codeErreur == '' && $validationCommande->noCommande == $noCommande) {
                    $filters =  [ "noCommande" => [
                            "value" =>  $noCommande,
                            "matchMode"=> "equals"
                        ]
                    ];

                    $params = [
                        "maxResults" => 1, // champs obligatoire compris entre 1 et 100
                        "offset" => 0,
                        "filters" => json_encode($filters),
                    ];

                    print "Recherche du reglement associe à la commande = ".$noCommande."<br>";
                    $response = callApiGet("/editeur/".REF_EDITEUR."/reglement", $token, $params);
                    if (property_exists($response, 'value')) {
                        $reglement = $response->value;
                        print "Mise à jour du reglement ".$reglement->refReglement." avec le numAppelTransaction = $numTransactionGoogle<br>";
                        $reglement->numAppelTransaction = $numTransactionGoogle;
                        $response = callApiPut("/editeur/".REF_EDITEUR."/reglement", $token, $reglement);
                    }
                }
            }
        }
    }
	
?>