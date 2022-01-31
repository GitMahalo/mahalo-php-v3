<?php
	require_once("../resttbs.php");
	
	////////////////////////////////////////////////////////////////////
	///////// 
	///////// ATTENTION La mise à jour des CS d'un client est en ANNULE ET REMLACE
	///////// Il faut donc au préalable faire une lecture des cs du client et repasser toute la liste
	///////// Les cs manquants seront supprimés pour le client en question
	///////// 
	////////////////////////////////////////////////////////////////////
	
	$codeClient = 1000;
	$codesSelections = [];
	$refCs = 1003; //référence interne du paramètre CS à ajouter sur le client
	$valeur = "VALEUR_DU_CS"; //Valeur à ajouter ou remplacer en fonction du mode de saisie du paramètre CS (valeur unique ou multiple)
	
	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);
	$ajoutCs = false;
	
	print "Lecture des codes de selections du crm du client ".$codeClient."<br>";
	$params = [
			"crm" => 0, // 0 (default) ou 1 indique si le codeSelection fait partie de la liste CRM ou non ATTENTION a bien checker les deux valeurs
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/codeselection", $token, $params);
	if(property_exists($response, 'value')) {
		foreach($response->value as $p){
			if($p->type == $refCs){
				$ajoutCs = false;
				if($p->multiple){
					//Ajout de la valeur dans la liste
					//NON GERE ACTUELLEMENT
					/*$codesSelections[]= [
							"id" => $p->id,
							"type" => $p->type,
							"libelle" => $p->libelle,
					];*/
				} else {
					//Remplacement de la valeur existante
					$codesSelections[]= [
							"id" => $p->id,
							"type" => $p->type,
							"libelle" => $valeur,
					];
				}
			} else {
				$codesSelections[]= [
						"id" => $p->id,
						"type" => $p->type,
						"libelle" => $p->libelle,
				];
			}
		}
	}
	
	print "Lecture des codes de selections hors crm du client ".$codeClient."<br>";
	$params = [
			"crm" => 1, // 0 (default) ou 1 indique si le codeSelection fair partie de la liste CRM ou non ATTENTION a bien checker les deux valeurs
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/codeselection", $token, $params);
	if(property_exists($response, 'value')) {
		foreach($response->value as $p){
			if($p->type == $refCs){
				$ajoutCs = false;
				if($p->multiple){
					//Ajout de la valeur dans la liste
					//NON GERE ACTUELLEMENT
					/*$codesSelections[]= [
							"id" => $p->id,
							"type" => $p->type,
							"libelle" => $p->libelle,
					];*/
				} else {
					//Remplacement de la valeur existante
					$codesSelections[]= [
							"id" => $p->id,
							"type" => $p->type,
							"libelle" => $valeur,
					];
				}
			} else {
				$codesSelections[]= [
						"id" => $p->id,
						"type" => $p->type,
						"libelle" => $p->libelle,
				];
			}
		}
	}
	
	//ajout d'un cs pour le client (la liste des cs disponibles est obtenu par l'api aidesaisie)
	if($ajoutCs){
		$codesSelections[] = [
				"type" => $refCs, //cle du parametre code selection, correspond au champ id de la structure obtenu par l'api aidesaisie
				"libelle" => $valeur // Quelque soit le type du Code de Sélection
		];
	}
	
	$params = [
			"codesSelection" => $codesSelections,
			"codeClient" => $codeClient
	];
	
	print_r($params);
	
	print "<br>Ajout ou modification du CS au client ".$codeClient."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/codeselection", $token, $params);
		
	print "Lecture des codes de selections du crm du client ".$codeClient."<br>";
	$params = [
			"crm" => 0, // 0 (default) ou 1 indique si le codeSelection fair partie de la liste CRM ou non ATTENTION a bien checker les deux valeurs
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/codeselection", $token, $params);
	
	print "Lecture des codes de selections hors crm du client ".$codeClient."<br>";
	$params = [
			"crm" => 1, // 0 (default) ou 1 indique si le codeSelection fair partie de la liste CRM ou non ATTENTION a bien checker les deux valeurs
			"codeClient" => $codeClient
	];
	$response = callApiGet("/editeur/".REF_EDITEUR."/codeselection", $token, $params);

?>
