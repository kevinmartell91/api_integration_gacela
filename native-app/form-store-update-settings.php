<?php
echo "save";
echo "<pre>" . print_r($_POST) . "</pre>";
if (isset($_POST['mode'])) {
    // default request : POST
    $request = "POST";
    if ($_POST['mode'] == 'edit-store') {
        $request = "PUT";
    }

    include "../config/env.php";

    $data_string = json_encode(array(
        "external_id" => $_POST['external_id'],
        "name" => $_POST['name'],
        "latitude" => $_POST['latitude'],
        "longitude" => $_POST['longitude'],
        "address" => $_POST['address'],
        "reference" => $_POST['reference'],
        "contact_name" => $_POST['contact_name'],
        "contact_lastname" => $_POST['contact_lastname'],
        "contact_phone" => $_POST['contact_phone'],
        "email" => $_POST['email'],
        "password" => $_POST['password'],
    ));


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gacela.dev/api/requests/store_creation',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $request,
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . DEV_COMPANY_API_TOKEN,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}
?>
<!-- to remove -->
<!-- <div class="response">
    DONE
</div> -->