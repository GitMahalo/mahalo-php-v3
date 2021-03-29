<?php
	if(!@include("param.php")) die("Pour utiliser les examples, renommer param.exemple.php et renseignez les valeurs requises");
	header( 'content-type: text/html; charset= iso-8859-1' );
	
	$urls = [
		"PROD" => [
			"PORTAL" => "https://portal.mahalo-app.io/oauth/token",
			"WS" => "https://api.mahalo-app.io/"
		],
		"PREPROD" => [
			"PORTAL" => "https://portal-preprod.mahalo-app.io/oauth/token",
			"WS" => "https://api-preprod.mahalo-app.io/aboweb"
		],
		"LOCAL" => [
				"PORTAL" => "https://localhost:8443/aboweb-portal/oauth/token",
				"WS" => "https://localhost:8443/aboweb-ws"
		]
	];
	
	if($urls[TARGET] === null){
		die("TARGET ".TARGET." not found");
	}
	
	function callApiGet($url, $token, $datas = null) {
		global $urls;
		$headers = array(
				'Authorization: BEARER '.$token,
				'Content-type: text/html; charset=utf-8'
			);
		
		$url_with_datas = $url;
		
		if($datas !== null){
			$url_with_datas .= '?'.http_build_query($datas);
		}
		
		return callApi($urls[TARGET]["WS"].$url_with_datas, "", "GET", $headers);
	}
	
	function callApiGetTypePdf($url, $token, $datas = null) {
		global $urls;
		$headers = array(
				'Authorization: BEARER '.$token,
				'Accept: application/pdf'
			);
		
		$url_with_datas = $url;
		
		if($datas !== null){
			$url_with_datas .= '?'.http_build_query($datas);
		}
		
		return callApi($urls[TARGET]["WS"].$url_with_datas, "", "GET", $headers, false);
	}

	function callApiPut($url, $token, $datas) {
		global $urls;
		$data_string = json_encode($datas);
		$headers = array(
				'Authorization: BEARER '.$token,
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string)
			);
		return callApi($urls[TARGET]["WS"].$url, $data_string, "PUT", $headers);
	}

	function callApiPost($url, $token, $datas, $datasQuery) {
		global $urls;
		$data_string = json_encode($datas);
		$headers = array(
				'Authorization: BEARER '.$token,
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string)
			);
		
		$url_with_datas = $url;

		if($datasQuery !== null){
			$url_with_datas .= '?'.http_build_query($datasQuery);
		}
		return callApi($urls[TARGET]["WS"].$url_with_datas, $data_string, "POST", $headers);
	}

	function callApiPatch($url, $token, $datas) {
		global $urls;
		$data_string = json_encode($datas);
		$headers = array(
				'Authorization: BEARER '.$token,
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string)
			);
		return callApi($urls[TARGET]["WS"].$url, $data_string, "PATCH", $headers);
	}

	function callApi($url, $data_string, $verb="GET", $headers, $json=true, $token=false) {
		
		$curl = curl_init();

		$opts = [
			CURLOPT_URL => $url,
			CURLOPT_POST => false,
			CURLOPT_CUSTOMREQUEST => $verb,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers,
		];
		
		if($verb !== "GET") {
			$opts[CURLOPT_POST] = true;
			$opts[CURLOPT_POSTFIELDS] = $data_string;
		}
		if($json === false && $token === false){// cas ou on veut afficher un pdf (mais pas pour l'appel WS Token)
			$opts[CURLOPT_HEADER] = true;
		}

		curl_setopt_array($curl, $opts);
		$executionStartTime = microtime(true);
		$response = curl_exec($curl);
		$executionEndTime = microtime(true);
		$seconds = $executionEndTime - $executionStartTime;
		if($json === true){ // on n'affiche pas de message pour le pdf (cas ou on appelle le WS Token)
			print "REPONSE en $seconds secondes<br>";
			print_r($response);
			print "<br>FIN REPONSE<br><br>";
		}
		if($json === true || $token === true){
			$response = json_decode($response);
		} else {
			$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$headers = substr($response, 0, $header_size);
			transferHeader($headers);
			$body = substr($response, $header_size);
			echo $body;
			/*
			## Alternative 1 : contenu transformé en data-url encodé en base64, accessible depuis un lien.
			
			$contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
			echo '<a href="data:'.$contentType.';base64,'.base64_encode($response).'" download="download.pdf">Download</a>';
			
			## Alternative 2 : enregistrement du contenu dans un répertoire du serveur
			
			file_put_contents('download.pdf', $response);
			
			*/
		}
		curl_close($curl);
		return $response;
	}

	function transferHeader($headers) {
		$dataHeader = explode("\r\n", $headers);
		foreach($dataHeader as $val) {
			header($val);
		}
	}

	function getToken($username, $password, $json=true) {
		global $urls;
		if($json === true){ // on affiche que dans le cas ou on veut du json
			print "Recuperation du token<br>";
		}
		
		$params = [
			'grant_type' => 'password',
			'username' => $username,
			'password' => $password,
		];
		
		$data_string = http_build_query($params);
		$headers = array(
			'Authorization: Basic YWJvd2ViOg==',
			'Content-Length: ' . strlen($data_string),
			'Content-Type: application/x-www-form-urlencoded'
		);
		
		$response = callApi($urls[TARGET]["PORTAL"], $data_string, "POST", $headers, $json, true);
		if($json === true){
			print "TOKEN API : ".$response->access_token."<br><br>";
		}
		return $response->access_token;
		
		/*$curl = curl_init();
		
		$params = [
			'grant_type' => 'password',
			'username' => $username,
			'password' => $password,
		];

		$data_string = http_build_query($params);
		//print_r($data_string);
		//print_r($urls[TARGET]["PORTAL"]);

		$opts = [
			CURLOPT_URL => $urls[TARGET]["PORTAL"],
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $data_string,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic YWJvd2ViOg==',
				'Content-Length: ' . strlen($data_string),
				'Content-Type: application/x-www-form-urlencoded'
			),
		];

		curl_setopt_array($curl, $opts);
		// curl_setopt($curl, CURLOPT_VERBOSE, 1);
		// curl_setopt($curl, CURLOPT_HEADER, 1);
		
		$response = curl_exec($curl);		
		curl_close($curl);
		// print_r($response);
		$response = json_decode($response);
		
		print "TOKEN API : ".$response->access_token."<br><br>";
		return $response->access_token;*/
	}


?>