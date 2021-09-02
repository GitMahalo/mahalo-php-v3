<?php
	require_once("../resttbs.php");
	
	$codeClient = 407044;
	
	$newAction = [];
	$newAction["codeClient"] = $codeClient;
	$newAction["type"] = "Email"; //Valeur possible : Courrier / Email / Tel / SMS / Notes / Ticket / Pige
	$newAction["object"] = "RELANCE EMAIL"; //Objet de l'action
	
	
	$dt = new DateTime();
	$dt->setTimeZone(new DateTimeZone('UTC'));
	$newAction["date"] = $dt->format('Y-m-d\TH:i:s.\0\0\0'); //date de l'action au format yyyy/mm/dd

	$dt->setTimeZone(new DateTimeZone('Europe/Paris'));
	$newAction["heure"] = $dt->format('H:i'); //heure de l'action au format hh:mm

	$newAction["refEtat"] = 1; //Modele Mahalo pour le template de mail obtenu par l'api etat (id) uniquement si type est Courrier ou Email
	$newAction["etatAction"] = false; //Action deja effectuee ou non
	
	$newAction["rappel"] = true; // Avec ou sans rappel
	$rappel = new DateTime("2021-12-12 15:40",new DateTimeZone('Europe/Paris')); //Date du rappel souhaite
	$newAction["heureRappel"] = $rappel->format('H:i'); //heure du rappel au format hh:mm
	$rappel->setTime(0, 0);
	$rappel->setTimezone(new DateTimeZone("UTC"));
	$newAction["dateRappel"] = $rappel->format('Y-m-d\TH:i:s.\0\0\0'); //date du rappel en UTC
	$newAction["utilRappel"] = "UTILISATEUR_ABOWEB"; //Nom Complet de l'utilisateur Aboweb lie au rappel de l'action
	$newAction["rappelEmailAddress"] = "utilisateurAboweb@masociete.com"; //Email de l'utilisateur Aboweb lie au rappel de l'action
	
	$newAction["etatRappel"] = 0; // le rappel est fait ou non
	$newAction["rappelEmail"] = 0; // rappeler par email


	$newAction["texte"] = "Texte du mail pour la nouvelle action";
	
	// $newAction["mailLog"] = null; // optionnel : utilise pour la partie Webhook

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	print_r($newAction);
	
	print "<br>Ajout de l'action sur le client ".$codeClient."<br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/action", $token, $newAction);

?>
