<?php	
	define("TARGET","PREPROD"); // Valeur possible PROD / PREPROD
	
	define("REF_EDITEUR",null); // (Integer) Reference de l'éditeur Aboweb
	define("REF_SOCIETE",null); // (Integer) Reference de la Société Aboweb (disponible via l'api GET editeur/{refEditeur}/societe)
	
	define("VALIDATION_COMMANDE",false); // Après l'insertion de la commande, il est possible de lancer la validation de la commande
	
	//Utilisateur pour la connexion aux API
	//deprecated - see https://github.com/GitMahalo/mahalo-php-v3/wiki/R%C3%A9cup%C3%A9ration-du-Token-d'authentification
	define("LOGIN","deprecated");
	define("CREDENTIAL","deprecated");

	define("BEARERTOKEN","");
	
	if(TARGET === ""){
		echo "param.php => la constante TARGET est requise";
		die();
	}
	if(REF_EDITEUR === null){
		echo "param.php => la constante REF_EDITEUR est requise";
		die();
	}
	if(REF_SOCIETE === null){
		echo "param.php => la constante REF_SOCIETE est requise";
		die();
	}
	/* DEPRECATED - see https://github.com/GitMahalo/mahalo-php-v3/wiki/R%C3%A9cup%C3%A9ration-du-Token-d'authentification
	if(LOGIN === ""){
		echo "param.php => la constante LOGIN est requise";
		die();
	}
	if(CREDENTIAL === ""){
		echo "param.php => la constante CREDENTIAL est requise";
		die();
	}*/

    define("ORIGINE","");
?>
