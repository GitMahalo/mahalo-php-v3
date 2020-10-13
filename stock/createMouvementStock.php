<?php
	require_once("./resttbs.php");
	
	// CREATION D'UN MOUVEMENT DE STOCK

	$params = [

	];		

	
	print "refStock : Obligatoire. Référence technique du stock<br>";
	print "notes : Facultatif. Si non renseigné un commentaire 'standard' est créé en indiquant le type de mouvement le sens et la quantité mouvementée<br>";
	print "quantiteMouvement : Obligatoire. Nombre d'unité(s) à mouvementer<br>";
	print "sensMouvement : Obligatoire. 11 : Entrée de stock, 12 : Sortie de stock<br>";
	print "sensMouvement : Obligatoire. Pas de contrôle pour les sorties de stock<br>";
	print "		Pour les commandes d'achat  : <br>";
	print " 		- Réception : Réception d'achats <br>";
	print " 		- Prévision  : Commande d'achats <br>";

	$mvt = [];		
	$mvt["refStock"] = 1; 
	$mvt["notes"] = ""; 
	$mvt["quantiteMouvement"] = 1; 
	$mvt["sensMouvement"] = '11'; 
	$mvt["typeMouvement"] = 'test'; 


	$token = getToken(LOGIN,CREDENTIAL);
	
	//TRAITEMENT DES CALL API
	print "Creation d'un mouvement de stock <br><br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/stock/mouvement",$token, $mvt, $params);
	
	
?>
