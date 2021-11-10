<?php
	require_once("../resttbs.php");
	
	//LECTURE DU REFERENTIEL Facture

    // Recupere tous les abonnements d'une commande 
	$filters = ["noCommande" => ["value" => "9957", "matchMode" => "equals"]];

    $params = [
    "maxResults" => 10, // champs obligatoire compris entre 1 et 100
    "filters" => json_encode($filters)
    ];
    
    //TRAITEMENT DES CALL API
    
    $token = getToken(LOGIN,CREDENTIAL);
    
    print "Recupere tous les abonnements d'une commande : ".$filters["noCommande"]["value"]." <br><br>";
    $response = callApiGet("/editeur/".REF_EDITEUR."/abonnement", $token, $params);
	
	$abonnements = $response->value;
    
    foreach($abonnements as $abonnement){
        $refFacture = $abonnement->refFacture;
        
        // Affichage des données de la facture
        print "Affichage des données de la facture = ".$refFacture." <br><br>";
        $response = callApiGet("/editeur/".REF_EDITEUR."/facture/".$refFacture, $token);

        // Affichage des données des lignes de la facture
        print "Affichage des données des lignes de la facture = ".$refFacture." <br><br>";
        $response = callApiGet("/editeur/".REF_EDITEUR."/lignefacture/details/" . $refFacture, $token);
        
        // Affichage de la facture au format pfd
        print "Pour avoir la facture au format PDF voir l'exemple : getFacturePdf.php avec la refFacture : ".$refFacture." <br><br>";
  
    }
?>