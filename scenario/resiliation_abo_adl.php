<?php
require_once("../resttbs.php");
header( 'content-type: text/html; charset= utf-8' );

// /!\ *******  Limitation ****** /!\
// 1- Seuls les abonnements à durée libre sont éligibles (ADL)

initHTML();

$codeClient=4988936;//Client concerné par la resiliation
$refAbonnement=2888286; // Reference d'un des abonnements (si formule) à arrêter
$refMotifSuspension = 229; // reference motif suspension


// TRAITEMENT DES CALL API

$token = getToken(LOGIN, CREDENTIAL, false);

//Lecture de l'abonnement
$response = callApiGet("/editeur/".REF_EDITEUR."/abonnement/".$refAbonnement, $token);

// Verification de l'éligibilité de l'abonnement au changement du moyen de paiement
if(property_exists($response, 'value') && $response->value !== null) {
	$abonnement = $response->value;
	$aboEligible = false;
	if( $abonnement->codeClient == $codeClient && 
		$abonnement->obsolete == false &&
		$abonnement->adl == true) {
		//Abonnement eligible -- suspension de l'abonnement à la date de fin
		$params = [];
	
		$paramsQuery = [
			"refAbonnement" => $abonnement->refAbonnement,
			"refMotifSuspension" => $refMotifSuspension,
			"numeroSuspension" => $abonnement->dns,
			"dateSuspension" => $abonnement->dateFin,
		];
		
		print "Suspension d'un abonnement : ".$abonnement->refAbonnement."<br><br>";
		$response = callApiPost("/editeur/".REF_EDITEUR."/suspension/suspendre/abonnement", $token, $params, $paramsQuery);
	} else {
		print_rr("Abonnement non eligible ".$abonnement->refAbonnement);
	}
}

endHTML();

?>
