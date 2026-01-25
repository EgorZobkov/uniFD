
<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-systems-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0 mb-3">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="geo_autodetect" <?php if($app->settings->geo_autodetect){ echo 'checked=""'; } ?>>
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_a5de07c42c64acb7b6b6e3d2cd328d22"); ?></span>
      </label>

    </div>

    <div class="col-12 mt-0 mb-3">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="multi_languages_status" <?php if($app->settings->multi_languages_status){ echo 'checked=""'; } ?>>
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_abd44990ae8b4a53122c45e690bc5969"); ?></span>
      </label>

    </div>

    <div class="col-12 mt-0 mb-3">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="system_captcha_status" <?php if($app->settings->system_captcha_status){ echo 'checked=""'; } ?>>
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_c550f49350fd798bf8c49bbd7c2014f2"); ?></span>
      </label>

    </div>

    <div class="col-12 mt-0 mb-3">

      <label class="form-label mb-2" ><?php echo translate("tr_17128ae3d8dfeeb3473fdcadf671bd65"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_timezone" >
              <?php echo $app->component->settings->getSystemsTimezone(); ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_3e87ef3705d47105921085130d3556c0"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="default_language" >
              <?php echo $app->component->translate->outLanguagesOptions($app->settings->default_language); ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_17a796f4cd63deef4bb7f0cc876a9c1f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <input type="number" class="form-control" name="confirmation_length_code" value="<?php echo $app->settings->confirmation_length_code; ?>" >          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_79819cd4da191d6fc6d043daa0a3fd8a"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <input type="number" class="form-control" name="system_captcha_attempts_count" value="<?php echo $app->settings->system_captcha_attempts_count; ?>" >          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_2ebd2f8e4ecc012c3e370889295f1d35"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <input type="number" class="form-control" name="system_verify_attempts_count" value="<?php echo $app->settings->system_verify_attempts_count; ?>" >          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_b60acd1fa2d715501bffac8512f3fbe5"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <div class="input-group">
              <input type="number" name="system_verify_block_time" class="form-control" value="<?php echo $app->settings->system_verify_block_time; ?>">  
              <span class="input-group-text"><?php echo translate("tr_9c48e720e677869578f57653ab18f6a6"); ?></span>
            </div>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="phone_confirmation_status" value="1" class="switch-input" <?php if($app->settings->phone_confirmation_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_5bbc2caded97292792bf2fd3a1c62239"); ?></span>
        </label>

        <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert">
          <?php echo translate("tr_1a2d608ba7163d2cae4902e316827cff"); ?>
        </div>

    </div>

    <div class="settings-profile-phone-confirmation-method-container" <?php if($app->settings->phone_confirmation_status){ echo 'style="display: block;"'; } ?> >
      
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_a1505099f7848924b1351e3da78554c5"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
              <select class="form-select selectpicker" name="phone_confirmation_service" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
                <option value="sms" <?php if(compareValues($app->settings->phone_confirmation_service,"sms")){ echo 'selected=""'; } ?> ><?php echo translate("tr_bb42dab4d6112cf327fbf787f5781b56"); ?></option>
                <option value="messenger" <?php if(compareValues($app->settings->phone_confirmation_service,"messenger")){ echo 'selected=""'; } ?> ><?php echo translate("tr_8f60e0a98d0f5606fe80ddbb5215a441"); ?></option>
              </select>
          </div>
        </div>

      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="email_confirmation_status" value="1" class="switch-input" <?php if($app->settings->email_confirmation_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_440d3105ae1e0037b4e54cf47b2b02f2"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="allowed_templates_email_all_status" value="1" class="switch-input" <?php if($app->settings->allowed_templates_email_all_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_cd027c2a50f31f7da9fefa28e2db820c"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="settings-profile-allowed-emails-container" <?php if(!$app->settings->allowed_templates_email_all_status){ echo 'style="display: block;"'; } ?> >
        
        <div class="col-12 mt-3">

          <label class="form-label mb-2" ><?php echo translate("tr_7c737527121aa031ecb20d8bc7be4969"); ?></label>

          <div class="row" >
            <div class="col-12 col-md-6" >
              <textarea class="form-control" name="allowed_templates_email" rows="4" placeholder="<?php echo translate("tr_ac7a8ac97b85484ed623efd1e60a77d7"); ?>" ><?php echo $app->settings->allowed_templates_email; ?></textarea>
            </div>
          </div>

        </div>

      </div>

    </div>

    <div class="col-12 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="allowed_templates_phone_all_status" value="1" class="switch-input" <?php if($app->settings->allowed_templates_phone_all_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_a216551a6bdab6687b7b45b0be07759a"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="settings-profile-allowed-phones-container" <?php if(!$app->settings->allowed_templates_phone_all_status){ echo 'style="display: block;"'; } ?> >
        
        <div class="col-12 mt-3">

          <label class="form-label mb-2" ><?php echo translate("tr_d2ff1d22da094da030770cafb955db3f"); ?></label>

          <div class="row" >
            <div class="col-12 col-md-6" >
              <select class="form-select selectpicker" name="allowed_templates_phone[]" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" multiple >
                <?php foreach ($app->config->phone_codes as $code => $value) { ?>
                  <option value="<?php echo $code; ?>" <?php if(compareValues($app->settings->allowed_templates_phone,$code)){ echo 'selected=""'; } ?> ><?php echo $value->country; ?>, <?php echo $value->code; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </div>

      </div>

    </div>

    <div class="col-12 mt-3">

        <div class="col-12 mt-0">

          <label class="form-label mb-2" ><?php echo translate("tr_466af9187a3ee6af29b3403de0de4b94"); ?></label>

          <div class="row" >
            <div class="col-12 col-md-6" >
              <select class="form-select selectpicker" name="default_template_phone_iso"  >
                <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
                <?php foreach ($app->config->phone_codes as $code => $value) { ?>
                  <option value="<?php echo $code; ?>" <?php if(compareValues($app->settings->default_template_phone_iso,$code)){ echo 'selected=""'; } ?> ><?php echo $value->country; ?>, <?php echo $value->code; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_b4484a2be5cc2633b3d1ce1d2585af3c"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

      <div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
        <?php echo translate("tr_e54472163aeea5031ec22a003d243ae4"); ?>
      </div>

      <div class="row" >
        <div class="col-12 col-md-12" >
            <textarea rows="6" name="frontend_scripts" class="form-control" ><?php echo $app->settings->frontend_scripts; ?></textarea>          
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_1884d1e33baaf37c5444c334163e40a8"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
        <?php echo translate("tr_ad1d8899a168fe756b7deab7fec2c994"); ?>
      </div>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <label class="switch">
              <input type="checkbox" class="switch-input" value="1" name="system_report_status" <?php if($app->settings->system_report_status){ echo 'checked=""'; } ?> >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label"><?php echo translate("tr_04e3d861cab252eb1d17875e682b30aa"); ?></span>
            </label>
        </div>
      </div>

    </div>

    <div class="col-12 col-md-6 mt-0 mb-3" >
        <label class="switch">
          <input type="checkbox" class="switch-input" value="1" name="system_report_send_if_zero" <?php if($app->settings->system_report_send_if_zero){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_1c29acc6ec0266135aafbd6841ce84a4"); ?></span>
        </label>
    </div>

    <div class="col-12 mb-3">

      <label class="form-label mb-2" ><?php echo translate("tr_9d5d513baccf1366994a269b220f608f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_report_recipients_ids[]" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
                <?php echo $app->component->settings->outUsersOnlyAdminOptions(); ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_f90bfbcc0897050f9db1ba4decb693b6"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_report_period" >
                <option value="1" <?php if(compareValues($app->settings->system_report_period, 1)){ echo 'selected=""'; } ?> ><?php echo translate("tr_f78f90254f329e1eb260f4711874a828"); ?></option>
                <option value="3" <?php if(compareValues($app->settings->system_report_period, 3)){ echo 'selected=""'; } ?> ><?php echo translate("tr_7b5c16a0965f36a7b420ff2f9aa04446"); ?></option>
                <option value="6" <?php if(compareValues($app->settings->system_report_period, 6)){ echo 'selected=""'; } ?> ><?php echo translate("tr_f60c617d09461048151d9a5d2c38e570"); ?></option>
                <option value="12" <?php if(compareValues($app->settings->system_report_period, 12)){ echo 'selected=""'; } ?> ><?php echo translate("tr_8c038a1a5fef16beef640885bccb7cdb"); ?></option>
                <option value="24" <?php if(compareValues($app->settings->system_report_period, 24)){ echo 'selected=""'; } ?> ><?php echo translate("tr_93288d339396819f52abc56f3d67ac56"); ?></option>
            </select>          
        </div>
      </div>

    </div>

    <div class="settings-system-report-send-time-container" <?php if(compareValues($app->settings->system_report_period, 24)){ echo 'style="display: block"'; } ?> >
      
      <div class="col-12 mt-3">

        <label class="form-label mb-2" ><?php echo translate("tr_acf1438e4ffdf31a16fa478794b2d37a"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
              <input type="time" name="system_report_send_time" class="form-control" value="<?php echo $app->settings->system_report_send_time; ?>" >          
          </div>
        </div>

      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_438ec5aa8b9c4e95f3d03a5ee1cffc1e"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_ea9f1d31116116458343da75605ae882"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_default_currency" >
              <?php echo $app->component->settings->getSystemsCurrencies(); ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_02106ec416115c4de7a39c68c83946e6"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_extra_currency[]" multiple >
              <?php echo $app->component->settings->getSystemsExtraCurrencies(); ?>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_69233f26b55fefe642eca442eecc979a"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_currency_position" >
              <option value="start" <?php if($app->settings->system_currency_position == "start"){ echo 'selected=""'; } ?> ><?php echo translate("tr_81ed1dbaef06d1cd13b9bba4278e6eb4"); ?></option>
              <option value="end" <?php if($app->settings->system_currency_position == "end"){ echo 'selected=""'; } ?> ><?php echo translate("tr_49cf087a5e02d4c743025b42233a2100"); ?></option>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >
          <label class="switch">
            <input type="checkbox" class="switch-input" value="1" name="system_currency_spacing" <?php if($app->settings->system_currency_spacing){ echo 'checked=""'; } ?>>
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_8919c3b514f176c192c9694c80f9f113"); ?></span>
          </label>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >
          <label class="switch">
            <input type="checkbox" class="switch-input" value="1" name="system_price_reduction_status" <?php if($app->settings->system_price_reduction_status){ echo 'checked=""'; } ?>>
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_c6790ecf27671df85803da84e31bcbe5"); ?></span>
          </label>          
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_cdcab0e89db18cdce5dc5acf753aa176"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="system_price_separator" >
              <option value="spacing" <?php if($app->settings->system_price_separator == "spacing"){ echo 'selected=""'; } ?> ><?php echo translate("tr_2b83bbd8c3354c9666e9948b78ca2a25"); ?></option>
              <option value="," <?php if($app->settings->system_price_separator == "."){ echo 'selected=""'; } ?> ><?php echo translate("tr_6c4d87e19640327cfed0220de602d2ed"); ?></option>
            </select>          
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_f21e5d5a36fd155d9e5eface1bf8b9b9"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

      <div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
        <?php echo translate("tr_3f2e1c156882386df4f5a978a1c1b7a0"); ?>
      </div>

      <div class="row" >

        <div class="settings-system-measurement-container" >
          <?php echo $app->component->settings->outSystemsPriceMeasurements("input"); ?>
        </div>

      </div>

      <span class="btn btn-sm btn-primary waves-effect waves-light settingsSystemAddMeasuremen mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_afb6c7452e64a62ef755b1c10779f17d"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

      <div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
        <?php echo translate("tr_88f8a8158a5ea0087ed2506c77a62459"); ?>
      </div>

      <div class="row" >

        <div class="settings-system-price-names-container" >
          <?php echo $app->component->settings->outSystemsPriceNames("input"); ?>
        </div>

      </div>

      <span class="btn btn-sm btn-primary waves-effect waves-light settingsSystemAddPriceNames mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_fa6cc5df2dd6a8a7a5e08e29ed308c5a"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_bd07fee4af8582edbba3e1faa256a36b"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-12" >
            <strong><?php echo getLinkCron(); ?></strong>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_a696702e0ba52860468fd857813d370f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <strong><?php echo $app->settings->system_version; ?></strong>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_48e37c9cc1750fe6b8c20e2c18be801f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <strong><?php echo $app->datetime->outDate($app->settings->system_last_update); ?></strong>          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_19bc30a69a42ebee22b9219fe4476926"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <strong><?php echo translate("tr_b161ab502edfb7350c72721af2b1b37b"); ?> ❤️ <a href="https://unisite.org/" target="_blank" >UniSite CMS</a> </strong>          
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_c59fd0599ceb55cd493242571e3cc261"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <div class="btn btn-secondary waves-effect waves-light buttonSettingsClearCache"><?php echo translate("tr_7074366a7567f200d45f7f99e7da037d"); ?></div>          
        </div>
      </div>

    </div>

  </div>

</div>
</div>

</div>
