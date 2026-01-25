<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-mailing-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_c2239a92bde29f0a9f9173193cc2fe00"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3">

      <label class="form-label mb-2" ><?php echo translate("tr_4c69bb5b559c2125c4095b7740ae02fc"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="mailer_from_name" class="form-control" value="<?php echo $app->settings->mailer_from_name; ?>" /> 
        </div>
      </div>

      <label class="form-label-error" data-name="mailer_from_name" ></label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_671ce6073c5559a08134fa12b64afce7"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <input type="text" name="mailer_from_email" class="form-control" value="<?php echo $app->settings->mailer_from_email; ?>" /> 
        </div>
      </div>

      <label class="form-label-error" data-name="mailer_from_email" ></label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_a6418b4a02221c7bbe1c19111775c872"); ?></label>

      <div class="settings-mailer-smtp-alert" <?php if(!$app->settings->mailer_service){ echo 'style="display:block"'; } ?> >
        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert" >
          <?php echo translate("tr_445d74a3e0e226ef5c754bdfe33e1d0c"); ?>
        </div>
      </div>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select settings-select-mailer-service selectpicker" name="mailer_service" >
              <option value="" <?php if(!$app->settings->mailer_service){ echo 'selected=""'; } ?> ><?php echo translate("tr_badafbd38de94b0e239bb077af72a44d"); ?></option>
              <option value="smtp" <?php if($app->settings->mailer_service == "smtp"){ echo 'selected=""'; } ?> ><?php echo translate("tr_0611439d2ada40c8649c7954c11e36fb"); ?></option>
              <?php
                $getSmtpServices = $app->component->settings->getSmtpServices();
                if($getSmtpServices){
                  foreach ($getSmtpServices as $key => $value) {
                    ?>
                    <option value="<?php echo $value["id"]; ?>" <?php if($app->settings->mailer_service == $value["id"]){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
                    <?php
                  }
                }
              ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="settings-mailer-services-container" <?php if($app->settings->mailer_service_api_key){ echo 'style="display:block"'; } ?> >
      
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_62c7594948c1231bbae9f948b1535b7e"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="mailer_service_api_key" class="form-control" value="<?php echo decrypt($app->settings->mailer_service_api_key); ?>" /> 
          </div>
        </div>

      </div>

    </div>

    <div class="settings-mailer-service-smtp-container mt-0" <?php if($app->settings->mailer_service == 'smtp'){ echo 'style="display:block"'; } ?> >
      
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_ca096ef6f84efadba2e5a86b81d12473"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="mailer_smtp_host" class="form-control" value="<?php echo $app->settings->mailer_smtp_host; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="mailer_smtp_host" ></label>

      </div>

      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_8964d94a1bf26979310cee3262f70091"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="mailer_smtp_port" class="form-control" value="<?php echo $app->settings->mailer_smtp_port; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="mailer_smtp_port" ></label>

      </div>

      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_5fe5313dd98f8f5c31ab39c22b629759"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="mailer_smtp_username" class="form-control" value="<?php echo $app->settings->mailer_smtp_username; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="mailer_smtp_username" ></label>

      </div>

      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_5ebe553e01799a927b1d045924bbd4fd"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="mailer_smtp_password" class="form-control" value="<?php echo $app->settings->mailer_smtp_password; ?>" /> 
          </div>
        </div>

        <label class="form-label-error" data-name="mailer_smtp_password" ></label>

      </div>

      <div class="col-12 mb-0 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_8bee4e0dffb9e637c94983d5526e5463"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="mailer_smtp_secure" >
              <option value="SSL" <?php if($app->settings->mailer_smtp_secure == "SSL"){ echo 'selected=""'; } ?> >SSL</option>
              <option value="TLS" <?php if($app->settings->mailer_smtp_secure == "TLS"){ echo 'selected=""'; } ?> >TLS</option>
            </select> 
          </div>
        </div>

        <label class="form-label-error" data-name="mailer_smtp_secure" ></label>

      </div>

    </div>

  </div>

  <span class="btn btn-label-warning waves-effect waves-light buttonSendTestMailSettings mt-2" ><?php echo translate("tr_c0840816b2bcc7d4f1495fa75aab6409"); ?></span>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_fd4a65755652573907656d02b16b58a4"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-0 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_563f88d7811825c3a63b395170065682"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
          <select class="form-select settings-select-mailer-template selectpicker" name="mailer_template_code" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <?php
              $getTemplates = $app->notify->actionsCode();
              foreach ($getTemplates as $key => $value) {
                 ?>
                 <option value="<?php echo $value["code"]; ?>" ><?php echo $value["code"]; ?></option>
                 <?php
              }
            ?>
          </select> 
        </div>
      </div>

      <div class="settings-mailer-template-container" >

        <div class="mt-3" >
        <textarea class="settings-mailer-template-body" ></textarea>
        </div>

      </div>

    </div>

  </div>

</div>
</div>

</div>
