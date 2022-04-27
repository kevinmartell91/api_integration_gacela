<?php

	include "config/env.php";

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://gacela.dev/api/tracking/coverage',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode(array(
		  "api_token" => DEV_STORE_API_TOKEN,
		  "destination_latitude" => -2.1598195,
		  "destination_longitude" => -79.9262071
	  )),
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Authorization: Bearer ' . DEV_COMPANY_API_TOKEN
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	//echo $response;




	echo "stores";

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://gacela.dev/api/company/stores_info',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Bearer ' . DEV_COMPANY_API_TOKEN
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;

?>