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
				'Content-Type: application/json'
			);
		
		$url_with_datas = $url;
		
		if($datas !== null){
			$url_with_datas .= '?'.http_build_query($datas);
		}
		
		return callApi($urls[TARGET]["WS"].$url_with_datas, "", "GET", $headers);
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

	function callApiPost($url, $token, $datas) {
		global $urls;
		$data_string = json_encode($datas);
		$headers = array(
				'Authorization: BEARER '.$token,
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string)
			);
		return callApi($urls[TARGET]["WS"].$url, $data_string, "POST", $headers);
	}

	function callApi($url, $data_string, $verb="GET", $headers) {
		
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

		curl_setopt_array($curl, $opts);
		$executionStartTime = microtime(true);
		$response = curl_exec($curl);
		curl_close($curl);
		$executionEndTime = microtime(true);
		$seconds = $executionEndTime - $executionStartTime;
		print "REPONSE en $seconds secondes<br>";
		print_r($response);
		print "<br>FIN REPONSE<br><br>";
		$response = json_decode($response);
		return $response;
	}

	function getToken($username, $password) {
		global $urls;
		print "Recuperation du token<br>";
		
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
		
		$response = callApi($urls[TARGET]["PORTAL"], $data_string, "POST", $headers);
		
		print "TOKEN API : ".$response->access_token."<br><br>";
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