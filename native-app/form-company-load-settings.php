<?php

$storeid = $_POST['storeId'];
$access_token = $_POST['accessToken'];
$url = 'https://app.ecwid.com/api/v3/' . $storeid . '/storage/public?token=' . $access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$settings_output = curl_exec($ch);

$settings_results  = json_decode($settings_output);
$settings = json_decode($settings_results->value);
// decode one more time for gacela settings
// there can be more application, so we reserve an object for gacela settings
$settings = $settings->gacela_settings;
// echo "<pre>" . print_r($settings, 1) . "</pre>";


// load stores from Gacela Api
include "../config/env.php";



// Start GET Store Request  => no records yet

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://gacela.dev/api/requests/store_creation/statuses',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer ' . DEV_COMPANY_API_TOKEN,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$data = json_decode($response, true);

echo "<pre>" . print_r($data, 1) . "</pre>";
// End GET Store Request 



curl_setopt_array($ch, array(
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

$response = curl_exec($ch);
curl_close($ch);


$result = json_decode($response, true);

$gacela_store_api_token = $result['results']['stores'][0]['api_token'];
$external_id = $result['results']['stores'][0]['external_id'];
$email = $result['results']['stores'][0]['email'];
$name = $result['results']['stores'][0]['name'];
$latitude = $result['results']['stores'][0]['latitude'];
$longitude = $result['results']['stores'][0]['longitude'];
$address = $result['results']['stores'][0]['address'];
$reference = $result['results']['stores'][0]['reference'];
$contact_name = $result['results']['stores'][0]['contact_name'];
$contact_lastname = $result['results']['stores'][0]['contact_lastname'];
$contact_phone = $result['results']['stores'][0]['contact_phone'];
$webhook_status_updates = $result['results']['stores'][0]['webhooks']['status_updates'];

?>

<div class="settings-page cf">
  <!-- Start header -->
  <div class="settings-page__header">
    <div class="settings-page__titles settings-page__titles--left">
      <h1 class="settings-page__title">
        Gacela servicio de delivery para su tienda
      </h1>
      <div class="settings-page__subtitle">
        Esta aplicación se conecta con el servicio de delivery de gacela
        para su configuracion respectiva.
      </div>
    </div>

    <!-- <div class="alert alert-success alert-icon">
          <div class="alert-inner">
            <div class="alert-content">
              <div class="icon">
                <span class="svg-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
                    <path
                      d="M34.5 67h-.13c-8.68-.03-16.83-3.45-22.94-9.61C5.32 51.23 1.97 43.06 2 34.38 2.07 16.52 16.65 2 34.5 2h.13c8.68.03 16.83 3.45 22.94 9.61 6.12 6.16 9.46 14.34 9.43 23.02C66.93 52.48 52.35 67 34.5 67zm0-62C18.3 5 5.06 18.18 5 34.39c-.03 7.88 3.01 15.3 8.56 20.89 5.55 5.59 12.95 8.69 20.83 8.72h.12c16.2 0 29.44-13.18 29.5-29.39.03-7.88-3.01-15.3-8.56-20.89C49.89 8.13 42.49 5.03 34.61 5h-.11z"
                    ></path>
                    <path
                      d="M32.17 46.67l-10.7-10.08c-.6-.57-.63-1.52-.06-2.12.57-.6 1.52-.63 2.12-.06l8.41 7.92 14.42-16.81c.54-.63 1.49-.7 2.12-.16.63.54.7 1.49.16 2.12L32.17 46.67z"
                    ></path>
                  </svg>
                </span>
              </div>
              <div class="title">
                This is an example alert you can show in your app.
              </div>
              <div>
                Use the alert messages to catch users’ attention. If you want to
                let your users know about a problem or successful operation in
                your app, use the alerts.
                <a onclick="postOpenPage('#components.alerts')">See Alerts</a>
              </div>
            </div>
          </div>
        </div> -->

    <div class="named-area">
      <div class="named-area__header">
        <div class="named-area__titles">
          <div class="named-area__title">Bienvenido</div>
          <div class="named-area__subtitle">
            Inicie la configuración de Gacela con los siguientes pasos.
            <a onclick="postOpenPage('#page-template.forms')">Gacela Link</a>
          </div>
        </div>
        <div class="named-area__description"></div>
        <div class="named-area__additional"></div>
      </div>
      <div class="named-area__body">
        <!-- start core config -->
        <div class="a-card-stack">
          <!-- Start config title -->
          <div class="a-card a-card--normal">
            <div class="a-card__paddings">
              <div class="feature-element has-icon">
                <div class="feature-element__core">
                  <div class="feature-element__data">
                    <div class="feature-element__title">
                      Configure su cuenta
                    </div>

                    <div class="feature-element__content">
                      <div class="feature-element__text">
                        <div class="titled-item">
                          <div class="titled-item__title"></div>
                          <div class="titled-item__content">
                            <div>
                              La información solicitada en este formulario
                              es proporciaonada pon Gacela.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="feature-element__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" data-name="Capa 1" viewBox="0 0 939.78 470.91">
                      <defs>
                        <style>
                          .cls-1 {
                            fill: #211915;
                          }

                          .cls-2 {
                            fill: #b67e2c;
                          }

                          .cls-3 {
                            fill: #da9500;
                          }

                          .cls-4 {
                            fill: #d89000;
                          }

                          .cls-5 {
                            fill: none;
                          }
                        </style>
                      </defs>
                      <title>logo</title>
                      <path class="cls-1" d="M429.58,568.14v4.77q0,31.8-21.17,52.87T361.8,648.24h-5a14.78,14.78,0,0,1-2.39-.2q-25.84-1.59-41.64-15.6t-23.16-30.71a75.67,75.67,0,0,1-5.47-16.1,69.56,69.56,0,0,1-1.69-14.31v-3q2.19-30.6,15.21-46.31T325.83,500A77.23,77.23,0,0,1,344,494.6a100.06,100.06,0,0,1,15.21-1.39,85,85,0,0,1,12,.89,97.57,97.57,0,0,1,12.62,2.68,94.38,94.38,0,0,1,20.08,8.65,72.9,72.9,0,0,1,17.89,14.41l-12.52,13.91q-7.16-9.14-20.57-17t-31.11-7.85q-25.84,1.19-41.14,18t-15.3,41.44q0,23.45,13.61,39.45T344.71,629a43.77,43.77,0,0,0,12.92,2q18.88,0,33.89-13.32t16.2-32l-39.15-.2V568.14Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M686.37,615v20.47a56.8,56.8,0,0,1-9.54,5.37,70.23,70.23,0,0,1-10.14,3.58,117.54,117.54,0,0,1-13.61,2.68,91.09,91.09,0,0,1-12,.9q-29.42,0-47.6-18.29T569.7,589.6a81.12,81.12,0,0,1-1.79-9.44,71.19,71.19,0,0,1-.6-9v-2.78q.79-29,14.21-45.12t29.32-23.45a87.34,87.34,0,0,1,34.78-8.15A97.16,97.16,0,0,1,668.38,494a66.29,66.29,0,0,1,18,7.15v21.67q-1.59-1.19-3.38-2.29t-3.38-2.29a73.14,73.14,0,0,0-16.9-7.65,57,57,0,0,0-16.3-2.49q-24.85,0-42.53,18.68T586.2,568.34q0,28.43,18.48,45T646.42,630c1.19,0,2.35,0,3.48-.1s2.29-.16,3.48-.3a63.83,63.83,0,0,0,17-4.47,60.6,60.6,0,0,0,16-9.84Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M786.34,496.19v17.29h-61v39h59.63v17.29H725.32v56.45h61v18.68H705V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M828.67,496.19v133h45.51v15.7H810V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M993.14,643.64,949.21,534.13,903.9,643.64H881.83l67.38-156.42L1015,643.64Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M200.16,383.36q-10.52,1.44-21.44,2.74s11.43,26.78,50.95,32a258.21,258.21,0,0,0-26.35,18.72,622.66,622.66,0,0,1,104-60.81C274.55,387.57,227.33,399.27,200.16,383.36Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-3" d="M690.2,201.37c-18.92-5.13-275.52-49.24-379.86-3.45,0,0,146.32-20.15,241.45,13.91,0,0-53.09,130.53-351.64,171.53,27.17,15.91,74.39,4.21,107.12-7.35A621.16,621.16,0,0,1,452,330.07c44.62-6,68.13-4.64,95.12.6,10.39-18.15,34-58.24,46-69.57,15.69-14.8,82.39-25.83,96.36-33.81S709.13,206.51,690.2,201.37Zm-69.31,7.36c14.58-8.85,28.11,2.55,28.11,2.55C633,220.7,620.89,208.74,620.89,208.74Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-4" d="M501.89,337.88q-9.68-.62-19.08-1a375.66,375.66,0,0,0-45.92,1.71,410.87,410.87,0,0,0-78.46,15.75c-50.14,15.12-104.78,41.25-162.9,83.15a362.43,362.43,0,0,0-64.41,66.14C105.94,537.39,83.26,581,75.22,634.26c0,0,32.51-45.14,84.38-94.72,26.42-25.25,57.86-51.66,92.58-73.82,14.26-12,36.05-26.17,67.65-42.67,54.34-35,119.58-65.84,195.69-83.39C510.68,338.93,506.11,338.34,501.89,337.88Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M542.68,643.64,498.76,534.13,453.45,643.64H431.38l67.38-156.42,65.79,156.42Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-5" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87h0Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87c-6.18-.47-12.49-.8-18.95-1Q492.15,337.26,501.76,337.87Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M624.18,394.73l-2-1.64c-16.75-13.35-52.92-39.17-97.12-52.7q-11.18-1.58-23.06-2.49c4.19.47,8.74,1.06,13.55,1.78h0l2.59.4-2.61-.39C439.39,357.22,374.17,388,319.83,423.05l.93-.49c33.06-17.2,70.27-26,108.23-29.21,51.23-9.92,123.53-16.28,191.72,4.45a2.49,2.49,0,0,0,3.47-3.08Z" transform="translate(-75.22 -177.33)" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End config title -->

          <!-- Start Paso 1  -->
          <div class="a-card a-card--compact a-card--has-hover">
            <div class="a-card__paddings">
              <div class="iconable-block iconable-block--info iconable-block--hide-in-mobile">
                <div class="iconable-block__infographics">
                  <span class="iconable-block__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" data-name="Capa 1" viewBox="0 0 939.78 470.91">
                      <defs>
                        <style>
                          .cls-1 {
                            fill: #211915;
                          }

                          .cls-2 {
                            fill: #b67e2c;
                          }

                          .cls-3 {
                            fill: #da9500;
                          }

                          .cls-4 {
                            fill: #d89000;
                          }

                          .cls-5 {
                            fill: none;
                          }
                        </style>
                      </defs>
                      <title>logo</title>
                      <path class="cls-1" d="M429.58,568.14v4.77q0,31.8-21.17,52.87T361.8,648.24h-5a14.78,14.78,0,0,1-2.39-.2q-25.84-1.59-41.64-15.6t-23.16-30.71a75.67,75.67,0,0,1-5.47-16.1,69.56,69.56,0,0,1-1.69-14.31v-3q2.19-30.6,15.21-46.31T325.83,500A77.23,77.23,0,0,1,344,494.6a100.06,100.06,0,0,1,15.21-1.39,85,85,0,0,1,12,.89,97.57,97.57,0,0,1,12.62,2.68,94.38,94.38,0,0,1,20.08,8.65,72.9,72.9,0,0,1,17.89,14.41l-12.52,13.91q-7.16-9.14-20.57-17t-31.11-7.85q-25.84,1.19-41.14,18t-15.3,41.44q0,23.45,13.61,39.45T344.71,629a43.77,43.77,0,0,0,12.92,2q18.88,0,33.89-13.32t16.2-32l-39.15-.2V568.14Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M686.37,615v20.47a56.8,56.8,0,0,1-9.54,5.37,70.23,70.23,0,0,1-10.14,3.58,117.54,117.54,0,0,1-13.61,2.68,91.09,91.09,0,0,1-12,.9q-29.42,0-47.6-18.29T569.7,589.6a81.12,81.12,0,0,1-1.79-9.44,71.19,71.19,0,0,1-.6-9v-2.78q.79-29,14.21-45.12t29.32-23.45a87.34,87.34,0,0,1,34.78-8.15A97.16,97.16,0,0,1,668.38,494a66.29,66.29,0,0,1,18,7.15v21.67q-1.59-1.19-3.38-2.29t-3.38-2.29a73.14,73.14,0,0,0-16.9-7.65,57,57,0,0,0-16.3-2.49q-24.85,0-42.53,18.68T586.2,568.34q0,28.43,18.48,45T646.42,630c1.19,0,2.35,0,3.48-.1s2.29-.16,3.48-.3a63.83,63.83,0,0,0,17-4.47,60.6,60.6,0,0,0,16-9.84Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M786.34,496.19v17.29h-61v39h59.63v17.29H725.32v56.45h61v18.68H705V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M828.67,496.19v133h45.51v15.7H810V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M993.14,643.64,949.21,534.13,903.9,643.64H881.83l67.38-156.42L1015,643.64Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M200.16,383.36q-10.52,1.44-21.44,2.74s11.43,26.78,50.95,32a258.21,258.21,0,0,0-26.35,18.72,622.66,622.66,0,0,1,104-60.81C274.55,387.57,227.33,399.27,200.16,383.36Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-3" d="M690.2,201.37c-18.92-5.13-275.52-49.24-379.86-3.45,0,0,146.32-20.15,241.45,13.91,0,0-53.09,130.53-351.64,171.53,27.17,15.91,74.39,4.21,107.12-7.35A621.16,621.16,0,0,1,452,330.07c44.62-6,68.13-4.64,95.12.6,10.39-18.15,34-58.24,46-69.57,15.69-14.8,82.39-25.83,96.36-33.81S709.13,206.51,690.2,201.37Zm-69.31,7.36c14.58-8.85,28.11,2.55,28.11,2.55C633,220.7,620.89,208.74,620.89,208.74Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-4" d="M501.89,337.88q-9.68-.62-19.08-1a375.66,375.66,0,0,0-45.92,1.71,410.87,410.87,0,0,0-78.46,15.75c-50.14,15.12-104.78,41.25-162.9,83.15a362.43,362.43,0,0,0-64.41,66.14C105.94,537.39,83.26,581,75.22,634.26c0,0,32.51-45.14,84.38-94.72,26.42-25.25,57.86-51.66,92.58-73.82,14.26-12,36.05-26.17,67.65-42.67,54.34-35,119.58-65.84,195.69-83.39C510.68,338.93,506.11,338.34,501.89,337.88Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M542.68,643.64,498.76,534.13,453.45,643.64H431.38l67.38-156.42,65.79,156.42Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-5" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87h0Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87c-6.18-.47-12.49-.8-18.95-1Q492.15,337.26,501.76,337.87Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M624.18,394.73l-2-1.64c-16.75-13.35-52.92-39.17-97.12-52.7q-11.18-1.58-23.06-2.49c4.19.47,8.74,1.06,13.55,1.78h0l2.59.4-2.61-.39C439.39,357.22,374.17,388,319.83,423.05l.93-.49c33.06-17.2,70.27-26,108.23-29.21,51.23-9.92,123.53-16.28,191.72,4.45a2.49,2.49,0,0,0,3.47-3.08Z" transform="translate(-75.22 -177.33)" />
                    </svg>
                  </span>
                </div>
                <div class="iconable-block__content">
                  <form class="company-settings-form">
                    <div class="form-area">
                      <div class="form-area__title">
                        Paso 1. Ingrese el API Token de la empresa
                      </div>

                      <div class="form-area__content">
                        <div class="fieldsets-batch">
                          <div class="fieldset">
                            <!-- <div class="fieldset__title">
                                Paso 1. Ingrese el API Token de la empresa
                              </div> -->
                            <div class="field field--medium">
                              <span class="fieldset__svg-icon"></span>
                              <label class="field__label">API token de empresa</label>
                              <input type="text" class="field__input" name="company_api_token" value="<?php echo $settings->company_api_token; ?>" tabindex="4" maxlength="64" />
                              <div class="field__placeholder">
                                API token de empresa
                              </div>
                            </div>
                            <div class="field__error" aria-hidden="true" style="display: none"></div>
                            <div class="fieldset__note">
                              Le permitira tener acces a uss tiendas o punto
                              de recojo.
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-area__title">
                        <span class="form-area__title-text">Modo sandbox</span>
                        <label class="checkbox tiny">
                          <input type="checkbox" name="sandbox" <?php if ($settings->sandbox == 'yes') {
                                                                  echo
                                                                  "checked";
                                                                } ?> value="yes">
                          <div data-on="enabled" data-off="disabled">
                            <div></div>
                          </div>
                        </label>
                      </div>
                    </div>
                    <div class="form-area__action" style="margin-top: 20px">
                      <input type="hidden" name="storeId" value="<?php echo $_POST['storeId']; ?>" />
                      <input type="hidden" name="accessToken" value="<?php echo $_POST['accessToken']; ?>" />
                      <button type="button" class="btn btn-primary btn-medium btn-company-setting-save" tabindex="5">

                        <span>Guardar</span>

                      </button>
                      <button style="display: none" class="btn btn-primary btn-medium btn-loading btn-company-setting-loading">
                        <span>Primary Large button</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End Paso 1  -->

          <!-- Start Paso 2  -->
          <div class="a-card a-card--compact a-card--has-hover">
            <div class="a-card__paddings">
              <div class="iconable-block iconable-block--info iconable-block--disabled iconable-block--hide-in-mobile">
                <div class="iconable-block__infographics">
                  <span class="iconable-block__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" data-name="Capa 1" viewBox="0 0 939.78 470.91">
                      <defs>
                        <style>
                          .cls-1 {
                            fill: #211915;
                          }

                          .cls-2 {
                            fill: #b67e2c;
                          }

                          .cls-3 {
                            fill: #da9500;
                          }

                          .cls-4 {
                            fill: #d89000;
                          }

                          .cls-5 {
                            fill: none;
                          }
                        </style>
                      </defs>
                      <title>logo</title>
                      <path class="cls-1" d="M429.58,568.14v4.77q0,31.8-21.17,52.87T361.8,648.24h-5a14.78,14.78,0,0,1-2.39-.2q-25.84-1.59-41.64-15.6t-23.16-30.71a75.67,75.67,0,0,1-5.47-16.1,69.56,69.56,0,0,1-1.69-14.31v-3q2.19-30.6,15.21-46.31T325.83,500A77.23,77.23,0,0,1,344,494.6a100.06,100.06,0,0,1,15.21-1.39,85,85,0,0,1,12,.89,97.57,97.57,0,0,1,12.62,2.68,94.38,94.38,0,0,1,20.08,8.65,72.9,72.9,0,0,1,17.89,14.41l-12.52,13.91q-7.16-9.14-20.57-17t-31.11-7.85q-25.84,1.19-41.14,18t-15.3,41.44q0,23.45,13.61,39.45T344.71,629a43.77,43.77,0,0,0,12.92,2q18.88,0,33.89-13.32t16.2-32l-39.15-.2V568.14Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M686.37,615v20.47a56.8,56.8,0,0,1-9.54,5.37,70.23,70.23,0,0,1-10.14,3.58,117.54,117.54,0,0,1-13.61,2.68,91.09,91.09,0,0,1-12,.9q-29.42,0-47.6-18.29T569.7,589.6a81.12,81.12,0,0,1-1.79-9.44,71.19,71.19,0,0,1-.6-9v-2.78q.79-29,14.21-45.12t29.32-23.45a87.34,87.34,0,0,1,34.78-8.15A97.16,97.16,0,0,1,668.38,494a66.29,66.29,0,0,1,18,7.15v21.67q-1.59-1.19-3.38-2.29t-3.38-2.29a73.14,73.14,0,0,0-16.9-7.65,57,57,0,0,0-16.3-2.49q-24.85,0-42.53,18.68T586.2,568.34q0,28.43,18.48,45T646.42,630c1.19,0,2.35,0,3.48-.1s2.29-.16,3.48-.3a63.83,63.83,0,0,0,17-4.47,60.6,60.6,0,0,0,16-9.84Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M786.34,496.19v17.29h-61v39h59.63v17.29H725.32v56.45h61v18.68H705V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M828.67,496.19v133h45.51v15.7H810V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M993.14,643.64,949.21,534.13,903.9,643.64H881.83l67.38-156.42L1015,643.64Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M200.16,383.36q-10.52,1.44-21.44,2.74s11.43,26.78,50.95,32a258.21,258.21,0,0,0-26.35,18.72,622.66,622.66,0,0,1,104-60.81C274.55,387.57,227.33,399.27,200.16,383.36Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-3" d="M690.2,201.37c-18.92-5.13-275.52-49.24-379.86-3.45,0,0,146.32-20.15,241.45,13.91,0,0-53.09,130.53-351.64,171.53,27.17,15.91,74.39,4.21,107.12-7.35A621.16,621.16,0,0,1,452,330.07c44.62-6,68.13-4.64,95.12.6,10.39-18.15,34-58.24,46-69.57,15.69-14.8,82.39-25.83,96.36-33.81S709.13,206.51,690.2,201.37Zm-69.31,7.36c14.58-8.85,28.11,2.55,28.11,2.55C633,220.7,620.89,208.74,620.89,208.74Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-4" d="M501.89,337.88q-9.68-.62-19.08-1a375.66,375.66,0,0,0-45.92,1.71,410.87,410.87,0,0,0-78.46,15.75c-50.14,15.12-104.78,41.25-162.9,83.15a362.43,362.43,0,0,0-64.41,66.14C105.94,537.39,83.26,581,75.22,634.26c0,0,32.51-45.14,84.38-94.72,26.42-25.25,57.86-51.66,92.58-73.82,14.26-12,36.05-26.17,67.65-42.67,54.34-35,119.58-65.84,195.69-83.39C510.68,338.93,506.11,338.34,501.89,337.88Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M542.68,643.64,498.76,534.13,453.45,643.64H431.38l67.38-156.42,65.79,156.42Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-5" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87h0Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87c-6.18-.47-12.49-.8-18.95-1Q492.15,337.26,501.76,337.87Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M624.18,394.73l-2-1.64c-16.75-13.35-52.92-39.17-97.12-52.7q-11.18-1.58-23.06-2.49c4.19.47,8.74,1.06,13.55,1.78h0l2.59.4-2.61-.39C439.39,357.22,374.17,388,319.83,423.05l.93-.49c33.06-17.2,70.27-26,108.23-29.21,51.23-9.92,123.53-16.28,191.72,4.45a2.49,2.49,0,0,0,3.47-3.08Z" transform="translate(-75.22 -177.33)" />
                    </svg>
                  </span>
                </div>
                <div class="iconable-block__content">
                  <!-- <form class="new-store-form"> -->
                  <!-- <div class="form-area">
                          <div class="form-area__title">
                            Paso 2. Configure sus puntos de recojo
                          </div>
                        </div> -->

                  <!--  -->
                  <div class="cta-block">
                    <div class="cta-block__central">
                      <div class="cta-block__title">
                        Paso 2. Agregue sus puntos de recojo
                      </div>
                      <div class="cta-block__content">
                        <div>
                          Cree un nuevo punto de recojo para su tienda
                          Loyalfy.
                        </div>
                        <div class="form-area__action" style="margin-top: 20px">
                          <!-- <input
                                  type="hidden"
                                  name="storeId"
                                  value="<?php echo $_POST['storeId']; ?>"
                                />
                                <input
                                  type="hidden"
                                  name="accessToken"
                                  value="<?php echo $_POST['accessToken']; ?>"
                                /> -->
                          <button type="button" class="btn btn-primary btn-medium btn-open-new-store-form" tabindex="5">
                            Crear nuevo punto de rocojo
                          </button>
                          <button style="display: none" class="btn btn-primary btn-medium btn-loading btn-open-new-store-form-loading">
                            <span>Primary Large button</span>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="cta-block__cta">
                      Si usted ya agregó un punto de recojo y esta ha sido
                      aprovada por Gacela, se listará en la parte inferior.
                    </div>
                  </div>
                  <!--  -->
                  <!-- </form> -->
                </div>
              </div>
            </div>
          </div>
          <!-- End of Paso 2 -->

          <!-- Start Paso 3  -->
          <div class="a-card a-card--compact a-card--has-hover">
            <div class="a-card__paddings">
              <div class="iconable-block iconable-block--info iconable-block--disabled iconable-block--hide-in-mobile">
                <div class="iconable-block__infographics">
                  <span class="iconable-block__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" data-name="Capa 1" viewBox="0 0 939.78 470.91">
                      <defs>
                        <style>
                          .cls-1 {
                            fill: #211915;
                          }

                          .cls-2 {
                            fill: #b67e2c;
                          }

                          .cls-3 {
                            fill: #da9500;
                          }

                          .cls-4 {
                            fill: #d89000;
                          }

                          .cls-5 {
                            fill: none;
                          }
                        </style>
                      </defs>
                      <title>logo</title>
                      <path class="cls-1" d="M429.58,568.14v4.77q0,31.8-21.17,52.87T361.8,648.24h-5a14.78,14.78,0,0,1-2.39-.2q-25.84-1.59-41.64-15.6t-23.16-30.71a75.67,75.67,0,0,1-5.47-16.1,69.56,69.56,0,0,1-1.69-14.31v-3q2.19-30.6,15.21-46.31T325.83,500A77.23,77.23,0,0,1,344,494.6a100.06,100.06,0,0,1,15.21-1.39,85,85,0,0,1,12,.89,97.57,97.57,0,0,1,12.62,2.68,94.38,94.38,0,0,1,20.08,8.65,72.9,72.9,0,0,1,17.89,14.41l-12.52,13.91q-7.16-9.14-20.57-17t-31.11-7.85q-25.84,1.19-41.14,18t-15.3,41.44q0,23.45,13.61,39.45T344.71,629a43.77,43.77,0,0,0,12.92,2q18.88,0,33.89-13.32t16.2-32l-39.15-.2V568.14Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M686.37,615v20.47a56.8,56.8,0,0,1-9.54,5.37,70.23,70.23,0,0,1-10.14,3.58,117.54,117.54,0,0,1-13.61,2.68,91.09,91.09,0,0,1-12,.9q-29.42,0-47.6-18.29T569.7,589.6a81.12,81.12,0,0,1-1.79-9.44,71.19,71.19,0,0,1-.6-9v-2.78q.79-29,14.21-45.12t29.32-23.45a87.34,87.34,0,0,1,34.78-8.15A97.16,97.16,0,0,1,668.38,494a66.29,66.29,0,0,1,18,7.15v21.67q-1.59-1.19-3.38-2.29t-3.38-2.29a73.14,73.14,0,0,0-16.9-7.65,57,57,0,0,0-16.3-2.49q-24.85,0-42.53,18.68T586.2,568.34q0,28.43,18.48,45T646.42,630c1.19,0,2.35,0,3.48-.1s2.29-.16,3.48-.3a63.83,63.83,0,0,0,17-4.47,60.6,60.6,0,0,0,16-9.84Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M786.34,496.19v17.29h-61v39h59.63v17.29H725.32v56.45h61v18.68H705V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M828.67,496.19v133h45.51v15.7H810V496.19Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M993.14,643.64,949.21,534.13,903.9,643.64H881.83l67.38-156.42L1015,643.64Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M200.16,383.36q-10.52,1.44-21.44,2.74s11.43,26.78,50.95,32a258.21,258.21,0,0,0-26.35,18.72,622.66,622.66,0,0,1,104-60.81C274.55,387.57,227.33,399.27,200.16,383.36Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-3" d="M690.2,201.37c-18.92-5.13-275.52-49.24-379.86-3.45,0,0,146.32-20.15,241.45,13.91,0,0-53.09,130.53-351.64,171.53,27.17,15.91,74.39,4.21,107.12-7.35A621.16,621.16,0,0,1,452,330.07c44.62-6,68.13-4.64,95.12.6,10.39-18.15,34-58.24,46-69.57,15.69-14.8,82.39-25.83,96.36-33.81S709.13,206.51,690.2,201.37Zm-69.31,7.36c14.58-8.85,28.11,2.55,28.11,2.55C633,220.7,620.89,208.74,620.89,208.74Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-4" d="M501.89,337.88q-9.68-.62-19.08-1a375.66,375.66,0,0,0-45.92,1.71,410.87,410.87,0,0,0-78.46,15.75c-50.14,15.12-104.78,41.25-162.9,83.15a362.43,362.43,0,0,0-64.41,66.14C105.94,537.39,83.26,581,75.22,634.26c0,0,32.51-45.14,84.38-94.72,26.42-25.25,57.86-51.66,92.58-73.82,14.26-12,36.05-26.17,67.65-42.67,54.34-35,119.58-65.84,195.69-83.39C510.68,338.93,506.11,338.34,501.89,337.88Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-1" d="M542.68,643.64,498.76,534.13,453.45,643.64H431.38l67.38-156.42,65.79,156.42Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-5" d="M515.52,339.66h0l2.61.39Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87h0Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M501.76,337.87c-6.18-.47-12.49-.8-18.95-1Q492.15,337.26,501.76,337.87Z" transform="translate(-75.22 -177.33)" />
                      <path class="cls-2" d="M624.18,394.73l-2-1.64c-16.75-13.35-52.92-39.17-97.12-52.7q-11.18-1.58-23.06-2.49c4.19.47,8.74,1.06,13.55,1.78h0l2.59.4-2.61-.39C439.39,357.22,374.17,388,319.83,423.05l.93-.49c33.06-17.2,70.27-26,108.23-29.21,51.23-9.92,123.53-16.28,191.72,4.45a2.49,2.49,0,0,0,3.47-3.08Z" transform="translate(-75.22 -177.33)" />
                    </svg>
                  </span>
                </div>
                <div class="iconable-block__content">
                  <!-- <form class="new-store-form"> -->
                  <!-- <div class="form-area">
                          <div class="form-area__title">
                            Paso 2. Configure sus puntos de recojo
                          </div>
                        </div> -->

                  <!--  -->
                  <div class="cta-block">
                    <div class="cta-block__central">
                      <div class="cta-block__title">
                        Paso 3. Selecione y edite su puntos de recojo
                      </div>
                      <div class="cta-block__content">
                        <div>
                          Esta opción le permite selecionar su punto de recojo aprovado por gacela y editarla.
                        </div>


                        <!-- loop for each store -->
                        <div class="flex-table">
                          <div class="flex-table__head">
                            <div class="flex-table__col flex-table__col--align-left">Nombre</div>
                            <div class="flex-table__col flex-table__col--align-center">Email</div>
                            <!-- <div class="flex-table__col flex-table__col--align-right">Nombre</div> -->
                            <div class="flex-table__col flex-table__col--align-right"></div>
                          </div>
                          <?php foreach ($result['results']['stores'] as $index => $array) : ?>
                            <div class="flex-table__row">

                              <div class="flex-table__col flex-table__col--align-left">
                                <?php echo $array['name']; ?>
                              </div>

                              <div class="flex-table__col flex-table__col--align-center">
                                <?php echo $array['email']; ?>
                              </div>

                              <div class="flex-table__col flex-table__col--align-right">
                                <!-- link button -->

                                <form class="store-edit-settings-form">
                                  <div class="form-area__action">
                                    <input type="hidden" name="storeId" value="<?php echo $array['external_id']; ?>" />
                                    <input type="hidden" name="store" value="<?php echo http_build_query($array); ?>" />
                                    <button type="button" class="btn btn-link btn-edit-settings-store" tabindex="5">
                                      <?php echo "Editar" ?>
                                    </button>
                                    <button style="display: none" class="btn btn-link btn-loading btn-edit-settings-store-loading">
                                      <span>Primary Large button</span>
                                    </button>
                                  </div>
                                </form>

                              </div>




                            </div>

                          <?php endforeach; ?>
                        </div>
                        <!-- loop for eac store -->

                      </div>
                    </div>
                    <!-- <div class="cta-block__cta">
                          Si usted ya agregó un punto de recojo y esta ha sido
                          aprovada por Gacela, se listará en la parte inferior.
                        </div>
                      </div>-->
                    <!--  -->
                    <!-- </form> -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Paso 2 -->
          </div>
          <!-- end core config -->
        </div>
      </div>
    </div>
    <!-- End header -->

    <!-- Store form section : crate and edit stores settings  -->
    <div class="store-form-section"></div>

  </div>

  <!-- JS for company settings  -->
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery("body").on("click", ".btn-company-setting-save", function(e) {
        e.preventDefault();
        jQuery(".btn-company-setting-loading").show();
        jQuery(this).hide();
        jQuery.ajax({
          url: "form-company-save-settings.php",
          type: "post",
          data: jQuery(".company-settings-form").serialize(),
          success: function(data) {
            jQuery(".btn-company-setting-save").show();
            jQuery(".btn-company-setting-loading").hide();
            // to remove
            jQuery(".store-form-section").html(data);

          },
          error: function(err) {
            console.log("tokens", err);
          }
        });

      });
    });
  </script>

  <!-- JS for showing a create-store form  -->
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery("body").on("click", ".btn-open-new-store-form", function(e) {
        e.preventDefault();
        jQuery(".btn-open-new-store-form-loading").show();
        jQuery(this).hide();
        jQuery.ajax({
          url: "form-store-load-settings.php",
          type: "post",
          data: {
            mode: "create-store",
            form: {
              title: 'Nuevo punto de rocojo',
              message: 'Rellene los campos solicitados'
            }
          },
          success: function(data) {
            jQuery(".btn-open-new-store-form").show();
            jQuery(".btn-open-new-store-form-loading").hide();
            jQuery(".store-form-section").html(data);
          },
          error(error) {
            console.log(error);
          },
        });
      });
    });
  </script>

  <!-- JS for EACH store settings  (for now to store 1 - static store)-->
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery("body").on("click", ".btn-edit-settings-store", function(e) {
        e.preventDefault();
        jQuery(".btn-edit-settings-store-loading").show();
        jQuery(this).hide();
        jQuery.ajax({
          url: "form-store-load-settings.php",
          type: "post",
          data: {
            mode: 'edit-store',
            form: {
              title: 'Editar punto de rocojo',
              message: 'Actualize los campos deseados'
            },
            json: jQuery(".store-edit-settings-form").serialize(),
          },
          success: function(data) {
            jQuery(".btn-edit-settings-store").show();
            jQuery(".btn-edit-settings-store-loading").hide();
            jQuery(".store-form-section").html(data);
          },
        });
      });
    });
  </script>
</div>