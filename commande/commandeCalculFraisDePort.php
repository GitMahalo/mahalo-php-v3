<?php
	require_once("../resttbs.php");

	// RECUPERATION DU NUMERO DE COMMANDE
	$noCommande = 25546;

	//TRAITEMENT DES CALL API

	$token = getToken(LOGIN,CREDENTIAL);

	print "Calcul des frais de port pour la commande = ".$noCommande."<br>";
	// Une ligne avec le montant des frais port est ajoutée sur la commande
	$response = callApiPost("/editeur/".REF_EDITEUR."/commande/".$noCommande."/fraisport", $token, "{}");
	/* La liste en retour contient :
		- une ligne avec le montant des FDP (divisé par le nombre de prélèvement si offre de prélèvement), montantTtc = portTtc, montatHt = portHt. Elle est identifiable pour la refTarif = offre "FDPWEB".
		- une ligne par offre avec le montantTtc et montantHt (divisé par le nombre de prélèvement si offre de prélèvement). Les ports sont ajoutés dans portTtc et PortHt.
	*/

?>
