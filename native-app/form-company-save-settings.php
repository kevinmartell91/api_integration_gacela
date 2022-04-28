<?php
// echo "<pre>SAVE ACCESS TOKEN</pre>";
echo "<pre>" . print_r($_POST, 1) . "</pre>";
$storeid = $_POST['storeId'];
$access_token = $_POST['accessToken'];
//print_r($data);
if (empty($_POST['sandbox'])) {
	$_POST['sandbox'] = "no";
}

$url = 'https://app.ecwid.com/api/v3/' . $storeid . '/storage/public?token=' . $access_token;
$data_string = json_encode(array(
	"gacela_settings" => array(
		"company_api_token" => $_POST['company_api_token'],
		"sandbox" => $_POST['sandbox']
	)
));


echo "<pre>" .  print_r($data_string, 1) . "</pre>";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8', 'Content-Length: ' . strlen($data_string)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
$settings_output = curl_exec($ch);
$settings_results  = json_decode($settings_output);
echo "<pre>" . print_r($settings_results, 1) . "</pre>";
curl_close($ch);
?>
<!-- <div class="test">
	DONE
</div> -->