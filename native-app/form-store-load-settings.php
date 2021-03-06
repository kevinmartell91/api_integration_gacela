<?php
// set as read mode when load this file
// echo "<pre>" .  print_r($_POST, 1) . "</pre>";
$readOnly = "fieldset--readonly";
if (isset($_POST['mode']) && $_POST['mode'] == 'edit-store') {
  // edit mode, so remove <fieldset--readonly> class
  $readOnly = "";

  parse_str($_POST['json'], $parsed);
  // foreach ($parsed as $key => $val) {
  //   // if ($key == 'external_id') {
  //   parse_str($val, $payload);
  //   // }
  // }
  $external_id = $parsed['external_id'];

  include "../config/env.php";
  $ch = curl_init();

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


  $response_decoded = json_decode($response, true);

  foreach ($response_decoded['results']['stores'] as $key => $store) {
    foreach ($store as $key => $value) {
      // look for selected storeId
      if ($key == 'external_id' && $value ==  $external_id) {
        $gacela_store_api_token = $store['api_token'];
        $external_id = $store['external_id'];
        $email = $store['email'];
        $name = $store['name'];
        $latitude = $store['latitude'];
        $longitude = $store['longitude'];
        $address = $store['address'];
        $reference = $store['reference'];
        $contact_name = $store['contact_name'];
        $contact_lastname = $store['contact_lastname'];
        $contact_phone = $store['contact_phone'];
        $webhook_status_updates = $store['webhooks']['status_updates'];
      }
    }
  }
}



if (isset($_POST['mode']) && ($_POST['mode']) == 'create-store') {
  // edit mode, so remove <fieldset--readonly> class
  $readOnly = "";
}

?>


<!-- Start body  -->
<div id="store-form" class="settings-page__bodyu" style="padding-bottom: 0.1px">
  <!-- Store 1 -->
  <div class="named-area">
    <div class="named-area__header">
      <div class="named-area__titles">
        <div class="named-area__title"><?php echo $_POST['form']['title'] ?></div>
        <div class="named-area__subtitle">
          <?php echo $_POST['form']['message'] ?>
          <a onclick="postOpenPage('#page-template.forms')">Gacela Link</a>
        </div>
      </div>
      <div class="named-area__description"></div>
      <div class="named-area__additional"></div>
    </div>
    <div class="named-area__body">
      <div class="a-card a-card--normal">
        <div class="a-card__paddings">
          <form class="new-store-settings-form" method='post' action>
            <div class="form-area">
              <div class="form-area__title form-area__title--medium">
                Datos de tu tienda
              </div>
              <!-- Start store external_id, name -->

              <div class="form-area__content">
                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start external_id -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Id de su tienda Loyalfy</label>
                      <input type="text" class="field__input" name="external_id" value="<?php echo $external_id; ?>" tabindex="4" maxlength="64" />
                      <div class="field__placeholder">
                        Id de tu tienda Loyalfy
                      </div>
                    </div>
                  </div>
                  <!-- End external_id -->

                  <!-- Start store name -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Nombre de la tienda</label>
                      <input type="text" class="field__input" name="name" value="<?php echo $name; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Nombre de la tienda
                      </div>
                    </div>
                  </div>
                  <!-- End store name -->
                </div>
                <p class="fieldset__note">
                  El storeId se ubica en la parte inferior izquierda de la
                  pantalla.
                </p>
              </div>
              <!-- End store external_id, name  -->


              <div class="form-area__title form-area__title--medium">
                Credenciales de acceso a Dashboard de Gacela
              </div>
              <!-- Start store email, password -->

              <div class="form-area__content">
                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store email -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Email de tienda</label>
                      <input type="text" class="field__input" name="email" value="<?php echo $email; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Email de tienda
                      </div>
                    </div>
                  </div>
                  <!-- End store email -->

                  <!-- Start store password -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Contrasena de acceso</label>
                      <input type="text" class="field__input" name="password" value="<?php echo $password; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Contrase??a de acceso
                      </div>
                    </div>
                  </div>
                  <!-- End store password -->
                </div>
                <p class="fieldset__note">
                  El storeId se ubica en la parte inferior izquierda de la
                  pantalla.
                </p>
              </div>
              <!-- End store email, password  -->

              <div class="form-area__title form-area__title--medium">
                Localizaci??n geografica de tu tienda
              </div>
              <!-- Start store latitude and longitude -->
              <div class="form-area__content">
                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store latitude -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Latitud de la tienda</label>
                      <input type="text" class="field__input" name="latitude" value="<?php echo $latitude; ?>" tabindex="4" maxlength="64" />
                      <div class="field__placeholder">
                        Latitud de la tienda
                      </div>
                    </div>
                    <div class="fieldset__note">Ejemplo: -1.106987</div>
                  </div>
                  <!-- End store latitude -->

                  <!-- Start store longitude -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Longitud de la tienda</label>
                      <input type="text" class="field__input" name="longitude" value="<?php echo $longitude; ?>" tabindex="4" maxlength="64" />
                      <div class="field__placeholder">
                        Longitud de la tienda
                      </div>
                    </div>
                    <div class="fieldset__note">Ejemplo: -79.8701069</div>
                  </div>
                  <!-- End store longitude -->
                </div>

                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store address -->

                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Direcci??n de la tienda</label>
                      <input type="text" class="field__input" name="address" value="<?php echo $address; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Direcci??n de la tienda
                      </div>
                    </div>
                  </div>
                  <!-- End store address -->
                </div>

                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store reference -->

                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Referencia de la tienda</label>
                      <input type="text" class="field__input" name="reference" value="<?php echo $reference; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Referencia de la tienda
                      </div>
                    </div>
                  </div>
                  <!-- End store reference -->
                </div>
                <p class="fieldset__note">
                  Cuales son las referencias para llegar a su local
                </p>
              </div>
              <!-- End store latitude and longitude-->

              <div class="form-area__title form-area__title--medium">
                Informaci??n de contacto de tu tienda
              </div>
              <!-- Start store contact_name and contact_lastname-->
              <div class="form-area__content">
                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store contact_name -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Nombre de contacto de la tienda</label>
                      <input type="text" class="field__input" name="contact_name" value="<?php echo $contact_name; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Nombre de contacto de la tienda
                      </div>
                    </div>
                  </div>
                  <!-- End store contact_name -->

                  <!-- Start store contact_lastname -->
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field field--medium">
                      <label class="field__label">Apelido de contacto de la tienda</label>
                      <input type="text" class="field__input" name="contact_lastname" value="<?php echo $contact_lastname; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Apelido de contacto de la tienda
                      </div>
                    </div>
                    <div class="fieldset__note">
                      <!-- ...and some description below -->
                    </div>
                  </div>
                  <!-- End store contact_lastname -->
                </div>
                <div class="fieldsets-batch fieldsets-batch--horizontal">
                  <!-- Start store contact_phone -->

                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Tel??fono de contacto de la tienda</label>
                      <input type="text" class="field__input" name="contact_phone" value="<?php echo $contact_phone; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Tel??fono de contacto de la tienda
                      </div>
                    </div>

                    <!-- <div class="fieldset__note">Ejemplo: 432432434</div> -->
                  </div>
                  <!-- End store contact_phone -->


                </div>
              </div>
              <!-- End store contact_name and contact_lastname-->

              <div class="form-area__title form-area__title--medium">
                Webhook
              </div>
              <!-- Start store webhooks.status_updates -->
              <div class="form-area__content">
                <div class="fieldsets-batch">
                  <div class="fieldset  <?php echo $readOnly; ?>">
                    <div class="field">
                      <label class="field__label">Url de webhook para actualizaciones de
                        status</label>
                      <input type="text" class="field__input" name="webhook_status_updates" value="<?php echo $webhook_status_updates; ?>" tabindex="4" maxlength="64" />

                      <div class="field__placeholder">
                        Url de webhook para actualizaciones de status
                      </div>
                    </div>
                    <div class="field__error" aria-hidden="true" style="display: none"></div>
                    <div class="fieldset__note">
                      Endpoint para las notificaiones de actualizaciones
                      de status de ordenes
                    </div>
                  </div>
                </div>
              </div>
              <!-- End store webhooks.status_updates -->

              <!-- <div class="form-area__content">
                    <div class="fieldsets-batch">
                      <div class="fieldset fieldset--select">
                        <div class="fieldset__title">One more field</div>
                        <div>
                          <div>
                            <div class="field field--medium field--filled">
                              <label class="field__label"></label>
                              <select class="field__select" tabindex="1">
                                <option value="NEW">New</option>
                                <option value="REFURBISHED">Refurbished</option>
                                <option value="USED">Used</option>
                              </select>
                              <div class="field__placeholder"></div>
                              <span class="field-state--success">
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="26px"
                                  height="26px"
                                  viewBox="0 0 26 26"
                                  focusable="false"
                                >
                                  <path
                                    d="M5 12l5.02 4.9L21.15 4c.65-.66 1.71-.66 2.36 0 .65.67.65 1.74 0 2.4l-12.3 14.1c-.33.33-.76.5-1.18.5-.43 0-.86-.17-1.18-.5l-6.21-6.1c-.65-.66-.65-1.74 0-2.41.65-.65 1.71-.65 2.36.01z"
                                  ></path>
                                </svg>
                              </span>
                              <span class="field-state--close">
                                <svg
                                  version="1.1"
                                  xmlns="http://www.w3.org/2000/svg"
                                  x="0px"
                                  y="0px"
                                  viewBox="0 0 16 16"
                                  enable-background="new 0 0 16 16"
                                  xml:space="preserve"
                                  focusable="false"
                                >
                                  <path
                                    d="M15.6,15.5c-0.53,0.53-1.38,0.53-1.91,0L8.05,9.87L2.31,15.6c-0.53,0.53-1.38,0.53-1.91,0 c-0.53-0.53-0.53-1.38,0-1.9l5.65-5.64L0.4,2.4c-0.53-0.53-0.53-1.38,0-1.91c0.53-0.53,1.38-0.53,1.91,0l5.64,5.63l5.74-5.73 c0.53-0.53,1.38-0.53,1.91,0c0.53,0.53,0.53,1.38,0,1.91L9.94,7.94l5.66,5.65C16.12,14.12,16.12,14.97,15.6,15.5z"
                                  ></path>
                                </svg>
                              </span>
                              <span class="field__arrow">
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 26 26"
                                  focusable="false"
                                >
                                  <path
                                    d="M7.85 10l5.02 4.9 5.27-4.9c.65-.66 1.71-.66 2.36 0 .65.67.65 1.74 0 2.4l-6.45 6.1c-.33.33-.76.5-1.18.5-.43 0-.86-.17-1.18-.5l-6.21-6.1c-.65-.66-.65-1.74 0-2.41.66-.65 1.72-.65 2.37.01z"
                                  ></path>
                                </svg>
                              </span>
                            </div>
                          </div>
                          <div
                            class="field__error"
                            aria-hidden="true"
                            style="display: none"
                          ></div>
                        </div>
                        <div class="fieldset__note"></div>
                      </div>
                    </div>
                  </div> -->

              <div class="form-area__action" style="margin-top: 20px">
                <!-- <input type="hidden" name="storeId" value="<?php echo $_POST['storeId']; ?>" /> -->
                <!-- <input type="hidden" name="accessToken" value="<?php echo $gacela_store_api_token; ?>" /> -->
                <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
                <button type="button" class="btn btn-primary btn-medium btn-create-new-store" tabindex="5">
                  Guardar
                </button>
                <button type="button" class="btn btn-secondary btn-medium btn-create-new-store-close" tabindex="5">
                  Cerrar
                </button>
                <button style="display: none" class="btn btn-primary btn-medium btn-loading btn-create-new-store-loading">
                  <span>Primary Large button</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End store 1 -->

  <div class="test-section"></div>
</div>
<!-- Start body -->

<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- JS for adding a store  -->
<script type="text/javascript">
  jQuery(document).ready(function() {
    console.log("JS for adding a store ");
    jQuery("#store-form").show();

    jQuery("body").on("click", ".btn-create-new-store", function(e) {
      e.preventDefault();
      jQuery(".btn-create-new-store-loading").show();
      jQuery(this).hide();
      // var mode;
      // if (jQuery("#mode").is(":checked")) {
      //   var mode = 1;
      // } else {
      //   var mode = 0;
      // }
      jQuery.ajax({
        url: "form-store-save-settings.php",
        type: "post",
        data: jQuery(".new-store-settings-form").serialize(), // + "&mode=" + mode,
        success: function(data) {
          jQuery(".btn-create-new-store").show();
          jQuery(".btn-create-new-store-loading").hide();
          jQuery(".test-section").html(data);
          // jQuery("#store-form").hide();
        },
        error(error) {
          console.log(error);
        },
      });
    });
    jQuery("body").on("click", ".btn-create-new-store-close", function(e) {
      e.preventDefault();
      jQuery("#store-form").hide();
    });
  });
</script>