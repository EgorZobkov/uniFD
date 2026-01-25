<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-integrations-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_4bbcdb86930e43635724cc518578b852"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_c83f7ab515c5cf6bed69213f55f917c7"); ?></label>

      <?php
      $getPaymentServices = $app->component->settings->getActivePaymentServices();
      if($getPaymentServices){
        ?>

        <div class="alert alert-primary d-flex align-items-center" role="alert">
          <?php echo translate("tr_b70be286305d535bd03284f8434bb678"); ?>
        </div>

        <div class="row" >
          <div class="col-12 col-md-6" >
              <select class="form-select selectpicker" name="integration_payment_services_active[]" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
                <?php
                    foreach ($getPaymentServices as $key => $value) {
                      ?>
                      <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->integration_payment_services_active,$value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
                      <?php
                    }
                ?>
              </select> 
          </div>
        </div>

        <div class="alert alert-primary d-flex align-items-center mt-3" role="alert">
          <?php echo translate("tr_68af8531aa24d310741ece3909b2d9e5"); ?>
        </div>

        <div class="row" >
          <div class="col-12 col-md-6" >
              <select class="form-select selectpicker" name="integration_payment_service_secure_deal_active" >
                <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
                <?php
                    foreach ($getPaymentServices as $key => $value) {
                      ?>
                      <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->integration_payment_service_secure_deal_active,$value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
                      <?php
                    }
                ?>
              </select> 
          </div>
        </div>

        <?php
      }else{
        ?>

        <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
          <?php echo translate("tr_cb78490b72f650891da63414124afb69"); ?>
        </div>

        <?php        
      }
      ?>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_4bbcdb86930e43635724cc518578b852"); ?></label>

      <div class="row" >
        <div class="col-12" >
          <div class="settings-integration-payments-edit-list" >
            <?php
              echo $app->component->settings->outPaymentServicesListEdit();
            ?> 
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_68c83fa9d2124c69367bcaae051a83dc"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_d3b9e440144ac3cb320cf4627f2e0e90"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="integration_messenger_service" >
              <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
              <?php echo $app->component->settings->outMessengerServicesOptions(); ?>
            </select> 
        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_68c83fa9d2124c69367bcaae051a83dc"); ?></label>

      <div class="row" >
        <div class="col-12" >
            <?php
              echo $app->component->settings->outMessengerServicesListEdit();
            ?> 
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_1860bda2662b9acb4c3b8c5464bda7fc"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_a51678b9986a94b1aa56987112c010e8"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select settings-select-integration-map-service selectpicker" name="integration_map_service" >
              <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
              <option value="yandex" <?php if(compareValues($app->settings->integration_map_service,"yandex")){ echo 'selected=""'; } ?> ><?php echo translate("tr_0c0a230358d00f0fcf81c28d23bf6e8c"); ?></option>
              <option value="google" <?php if(compareValues($app->settings->integration_map_service,"google")){ echo 'selected=""'; } ?> ><?php echo translate("tr_8b36e9207c24c76e6719268e49201d94"); ?></option>
              <option value="openmapstreet" <?php if(compareValues($app->settings->integration_map_service,"openmapstreet")){ echo 'selected=""'; } ?> ><?php echo translate("tr_112a1cf9e3e42403162f7626f5cb07e7"); ?></option>
            </select> 
        </div>
      </div>

    </div>

    <div class="settings-integration-service-api-key-container" <?php if($app->settings->integration_map_service){ echo 'style="display:block"'; } ?> >
      <div class="col-12">

        <label class="form-label mb-2" ><?php echo translate("tr_6252727443e5a8de378aba95bd2405c8"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="integration_map_key" class="form-control" value="<?php echo $app->settings->integration_map_key; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="integration_map_key" ></label>

      </div>
    </div>

    <?php if($app->settings->integration_map_service){ ?>
    <?php if($app->addons->map($app->settings->integration_map_service)->langs()){ ?>
    <div class="settings-integration-service-api-key-container" <?php if($app->settings->integration_map_service){ echo 'style="display:block"'; } ?> >
      <div class="col-12">

        <label class="form-label mb-2" ><?php echo translate("tr_0577df9ad7a2256702cd04371b2abecb"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="integration_map_lang" >
              <?php
                if($app->settings->integration_map_service){ 
                  foreach ($app->addons->map($app->settings->integration_map_service)->langs() as $key => $value) {
                     ?>
                     <option value="<?php echo $value; ?>" <?php if(compareValues($app->settings->integration_map_lang,$value)){ echo 'selected=""'; } ?> ><?php echo $value; ?></option>
                     <?php
                  }
                }
              ?>
            </select> 
          </div>
        </div>

      </div>
    </div>
    <?php } ?>
    <?php } ?>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_c83f7ab515c5cf6bed69213f55f917c7"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="integration_delivery_services_active[]" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
              <?php echo $app->component->settings->outDeliveryServicesOptions(); ?>
            </select> 
        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_0766bdd5ec3b1eb45348825d77cbb7d6"); ?></label>

      <div class="row" >
        <div class="col-12" >
            <?php
              echo $app->component->settings->outDeliveryServicesListEdit();
            ?> 
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4" id="integration-sms-service" >
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_a27847bc75d37f64e0a67c7a92b5c5c8"); ?></h3>
</div>
<div class="card-body">

  <div class="alert alert-primary d-flex align-items-center" role="alert">
    <?php echo translate("tr_a38d258314e5341efc098df546ecec46"); ?>
  </div>

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_a51678b9986a94b1aa56987112c010e8"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select settings-select-integration-sms-service selectpicker" name="integration_sms_service" >
              <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
              <?php echo $app->component->settings->outSmsServicesOptions(); ?>
            </select> 
        </div>

      </div>

      <div class="settings-integration-sms-service-container-options" <?php if($app->settings->integration_sms_service){ echo 'style="display:block;"'; } ?> >
        <?php
          if($app->settings->integration_sms_service){
            echo $app->addons->sms($app->settings->integration_sms_service)->fieldsForm();
          }
        ?>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_8e3b6579ba4fe18a570eadb3020a9baf"); ?></h3>
</div>
<div class="card-body">

  <div class="row g-3">

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_c83f7ab515c5cf6bed69213f55f917c7"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" multiple name="auth_services_list[]" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
              <?php echo $app->component->settings->outOAuthServicesOptions(); ?>
            </select> 
        </div>
      </div>

    </div>

    <div class="col-12">

      <label class="form-label mb-2" ><?php echo translate("tr_74846c1f5c480ef0e34aabcd1a88f02c"); ?></label>

      <div class="row" >
        <div class="col-12" >
            <?php
              echo $app->component->settings->outOAuthServicesListEdit();
            ?> 
        </div>
      </div>

    </div>

  </div>

</div>
</div>

</div>