<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-market-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" class="switch-input" value="1" name="basket_status" <?php if($app->settings->basket_status){ echo 'checked=""'; } ?>>
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_b7697b9693d25ce37bc6a91130dc3cb7"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" class="switch-input" value="1" name="shops_status" <?php if($app->settings->shops_status){ echo 'checked=""'; } ?>>
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="paid_services_status" <?php if($app->settings->paid_services_status){ echo 'checked=""'; } ?>>
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_7b1c170a6d767f68a49d7e9b001047a3"); ?></span>
      </label>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_9df9b0e88e848c47934a227c3e71a068"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">
            
           <select name="board_cost_publication_type" class="form-select selectpicker settings-board-select-cost-publication" >
             <option value="free" <?php if(compareValues($app->settings->board_cost_publication_type, "free")){ echo 'selected=""'; } ?> ><?php echo translate("tr_0e0dbc1e1abc2b82e10e54692d558df1"); ?></option>
             <option value="paid" <?php if(compareValues($app->settings->board_cost_publication_type, "paid")){ echo 'selected=""'; } ?> ><?php echo translate("tr_6a44b978f8312f735811e90078d75106"); ?></option>
           </select>

        </div>
      </div>

      <div class="settings-board-cost-publication-container" <?php if(compareValues($app->settings->board_cost_publication_type, "paid")){ echo 'style="display:block"'; } ?> >

        <div class="alert alert-primary d-flex align-items-center mt-2 mb-0" role="alert">
          <?php echo translate("tr_22e0d76ac52f440480554e926be19deb"); ?>
        </div>

        <div class="col-12 mt-3">

          <label class="form-label mb-2"><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?></label>

          <div class="row">
            <div class="col-6">

              <div class="input-group">
                <input type="number" class="form-control" name="board_cost_publication" value="<?php echo $app->settings->board_cost_publication; ?>" >
                <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
              </div>

            </div>
          </div>

        </div>

      </div>      

    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_9a3dc867f2fd583f53c561442ecf34b0"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mb-3">

        <label class="form-label mb-2"><?php echo translate("tr_82fd44f6b400e61240d8ea1fdc64ae3f"); ?></label>

        <div class="row">
          <div class="col-6">

            <div class="input-group">
              <input type="number" class="form-control" name="secure_deal_profit_percent" value="<?php echo $app->settings->secure_deal_profit_percent; ?>" step="0.01" >
              <span class="input-group-text">%</span>
            </div>

          </div>
        </div>

        <div class="alert alert-primary d-flex align-items-center mb-0 mt-2" role="alert">
          <?php echo translate("tr_32d7b96cddcbe6ce1dbeea57204b0b61"); ?>
        </div>

      </div>

      <div class="col-12">

        <label class="form-label mb-2"><?php echo translate("tr_424a51b6f623cc765b4f1df40a2e54cb"); ?></label>

        <div class="row">
          <div class="col-6">

            <div class="input-group">
              <input type="number" name="secure_deal_auto_closing_time" class="form-control" value="<?php echo $app->settings->secure_deal_auto_closing_time; ?>" >  
              <span class="input-group-text"><?php echo translate("tr_c183655a02377815e6542875555b1340"); ?></span>
            </div>

          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_bfc95980634bf529e8a406db2c842b31"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mb-3">

        <label class="form-label mb-2"><?php echo translate("tr_92914eedeaae6dce2fb88cabad714909"); ?></label>

        <div class="row">
          <div class="col-12">

            <textarea class="form-control" name="search_stopwords" rows="4" ><?php echo $app->settings->search_stopwords; ?></textarea>

          </div>
        </div>

        <div class="alert alert-primary d-flex align-items-center mb-0 mt-2" role="alert">
          <?php echo translate("tr_b9f24fca09f8b13896be5e4ddb1b580d"); ?>
        </div>

      </div>

      <div class="col-12 mb-3">

          <label class="switch">
            <input type="checkbox" class="switch-input" value="1" name="search_allowed_text" <?php if($app->settings->search_allowed_text){ echo 'checked=""'; } ?>>
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_d84c542213d85dce52393e467cf03bce"); ?></span>
          </label>

      </div>

      <div class="col-12">

        <label class="form-label mb-2"><?php echo translate("tr_66bae8c4950674c4b354977525160023"); ?></label>

        <div class="row">
          <div class="col-6">

            <select name="search_allowed_tables[]" class="form-select selectpicker" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
              <option value="keywords" <?php if(compareValues($app->settings->search_allowed_tables, "keywords")){ echo 'selected=""'; } ?> ><?php echo translate("tr_83dc72c7b853982cd4d3cbddf0254061"); ?></option>
              <option value="filters" <?php if(compareValues($app->settings->search_allowed_tables, "filters")){ echo 'selected=""'; } ?> ><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></option>
              <option value="shops" <?php if(compareValues($app->settings->search_allowed_tables, "shops")){ echo 'selected=""'; } ?> ><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></option>
              <option value="ads" <?php if(compareValues($app->settings->search_allowed_tables, "ads")){ echo 'selected=""'; } ?> ><?php echo translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"); ?></option>
            </select>

          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_424b696a1620af969ab9890f366df30d"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0 mb-3">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_moderation_status" <?php if($app->settings->board_publication_moderation_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_ec151ad4de23f10c3b6fef418a0594ef"); ?></span>
      </label>

    </div>

    <div class="settings-board-publication-moderation-container" <?php if(!$app->settings->board_publication_moderation_status){ echo 'style="display:block"'; } ?> >

      <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" class="switch-input" value="1" name="board_publication_smart_moderation_status" <?php if($app->settings->board_publication_smart_moderation_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_afdfaeb878e48a6497627a0e52f771a3"); ?></span>
        </label>

        <div class="alert alert-primary d-flex align-items-center mt-2 mb-0" role="alert">
          <?php echo translate("tr_42176853f77277a73a3d06b7e552ff91"); ?>
        </div>

      </div>

    </div>

    <div class="col-12">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_premoderation_status" <?php if($app->settings->board_publication_premoderation_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_b9c21b552729d8fc9bc36fc9bfd06541"); ?></span>
      </label>

    </div>

    <div class="settings-board-publication-premoderation-container" <?php if($app->settings->board_publication_premoderation_status){ echo 'style="display:block"'; } ?> >
      
      <div class="col-12 mb-3 mt-3">

        <label class="form-label mb-2"><?php echo translate("tr_fdf0fa4867e9f501c32abf3e4292dc95"); ?></label>

        <div class="row">
          <div class="col-6">

            <select name="board_publication_premoderation_conditions[]" class="form-select selectpicker" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
              <option value="email" <?php if(compareValues($app->settings->board_publication_premoderation_conditions, "email")){ echo 'selected=""'; } ?> ><?php echo translate("tr_22fada94f73ba2b0b6f7afc548395bf7"); ?></option>
              <option value="phone" <?php if(compareValues($app->settings->board_publication_premoderation_conditions, "phone")){ echo 'selected=""'; } ?> ><?php echo translate("tr_c5e824a6544d2b7aa63417d4db985102"); ?></option>
              <option value="link" <?php if(compareValues($app->settings->board_publication_premoderation_conditions, "link")){ echo 'selected=""'; } ?> ><?php echo translate("tr_a7c3a61c5e9939ceb9bdd6d68bb7c490"); ?></option>
            </select>

          </div>
        </div>

      </div>

      <div class="col-12 mt-0">

        <label class="form-label mb-2"><?php echo translate("tr_3ee384871fac6b9053173de1cc58e219"); ?></label>

        <div class="row">
          <div class="col-12 col-md-12">

            <textarea class="form-control" name="board_publication_forbidden_words" rows="5" ><?php echo $app->settings->board_publication_forbidden_words; ?></textarea>

          </div>
        </div>

        <div class="alert alert-primary d-flex align-items-center mt-2 mb-0" role="alert">
          <?php echo translate("tr_db8ff4686dc394321ddf70498f54b198"); ?>
        </div>

      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_1abe83d1461657b8e9d5516cc4d82828"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_required_phone_number" <?php if($app->settings->board_publication_required_phone_number){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_3e4c19c3fcca6c4a4a8c2845a681371d"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_required_email" <?php if($app->settings->board_publication_required_email){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_a101cd597a61bd845649028920641f5f"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_required_contact_max" <?php if($app->settings->board_publication_required_contact_max){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_4f8ae92df0933134b9fbc6706b7e02f2"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_required_contact_whatsapp" <?php if($app->settings->board_publication_required_contact_whatsapp){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_6f1cda9a831840f4346c000df276a807"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_required_contact_telegram" <?php if($app->settings->board_publication_required_contact_telegram){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_7748adb3a6e778905fdeb0d93f2f539e"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_only_photos" <?php if($app->settings->board_publication_only_photos){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_4dd355fd8add9d1447b71e154f59daed"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_currency_status" <?php if($app->settings->board_publication_currency_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_ef49ebd1988eb9c25814e97fe513c296"); ?></span>
      </label>

      <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert">
        <?php echo translate("tr_d8c76986369452c8d76e1dc81702722f"); ?>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_term_date_status" <?php if($app->settings->board_publication_term_date_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_c09ae38ce1a93e3a6dcf6795029466d1"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_add_video_status" <?php if($app->settings->board_publication_add_video_status){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_01d248d1e1be4010aa0b0fd40e6d10ff"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_publication_partner_products_active_tariffs" <?php if($app->settings->board_publication_partner_products_active_tariffs){ echo 'checked=""'; } ?> >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_77c63391f7e0cf912a2fdda671e1f0b2"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_87c11d49ef4c9b0036435fe4b856fc4f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" name="board_publication_term_date_default" class="form-control" value="<?php echo $app->settings->board_publication_term_date_default; ?>" >  
              <span class="input-group-text"><?php echo translate("tr_c183655a02377815e6542875555b1340"); ?></span>
            </div>
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3">

      <label class="form-label mb-2"><?php echo translate("tr_23183dbc6d85e301e431bc2f8f196efb"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

          <input type="number" name="board_publication_limit_count_media" class="form-control" value="<?php echo $app->settings->board_publication_limit_count_media; ?>" >

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_554c9f9113d06e48dc70b06a8b53a165"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" name="board_publication_max_size_image" class="form-control" value="<?php echo $app->settings->board_publication_max_size_image; ?>" >  
              <span class="input-group-text"><?php echo translate("tr_505c12388f06a422b00aa0ac07de72c5"); ?></span>
            </div>
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_d219ae3241c9dcf6e26a125bb840158a"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" name="board_publication_max_size_video" class="form-control" value="<?php echo $app->settings->board_publication_max_size_video; ?>" >  
              <span class="input-group-text"><?php echo translate("tr_505c12388f06a422b00aa0ac07de72c5"); ?></span>
            </div>
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_b5bd07ce3b225a9a9c4fd69fa624aeec"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <input type="number" name="board_publication_min_length_title" class="form-control" value="<?php echo $app->settings->board_publication_min_length_title; ?>" >  
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_8583d5bc9fba4839c605780afb537e0f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <input type="number" name="board_publication_max_length_title" class="form-control" value="<?php echo $app->settings->board_publication_max_length_title; ?>" >  
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_ed5fb9c0cac61b3dd794da60908292e3"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <input type="number" name="board_publication_min_length_text" class="form-control" value="<?php echo $app->settings->board_publication_min_length_text; ?>" >  
     
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_6eb6958478d60557fd25a2180625c712"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <input type="number" name="board_publication_max_length_text" class="form-control" value="<?php echo $app->settings->board_publication_max_length_text; ?>" >  
     
        </div>
      </div>

    </div>

  </div>


</div>
</div>


<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_05472eb3cc72641ed9a1454282a9c3b8"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="switch">
        <input type="checkbox" class="switch-input" value="1" name="board_card_price_different_currencies" <?php if($app->settings->board_card_price_different_currencies){ echo 'checked=""'; } ?>>
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label"><?php echo translate("tr_40d651905ac1ca75a5e71b0cb7f505ff"); ?></span>
      </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_4d608b1b495b57aa069ebc7bd95d6d12"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

           <select name="board_card_who_phone_view" class="form-select selectpicker" >
             <option value="auth" <?php if(compareValues($app->settings->board_card_who_phone_view, "auth")){ echo 'selected=""'; } ?> ><?php echo translate("tr_879630a9cd0767eeb6b73d15ad3ce4a4"); ?></option>
             <option value="all" <?php if(compareValues($app->settings->board_card_who_phone_view, "all")){ echo 'selected=""'; } ?> ><?php echo translate("tr_984bf1497dea9513aa66cf7b0e1eeb0e"); ?></option>
           </select>  
     
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_d9a01d72d3cda8f2f6e88a80ee308e84"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

           <select name="board_card_who_transition_partner_link" class="form-select selectpicker" >
             <option value="auth" <?php if(compareValues($app->settings->board_card_who_transition_partner_link, "auth")){ echo 'selected=""'; } ?> ><?php echo translate("tr_879630a9cd0767eeb6b73d15ad3ce4a4"); ?></option>
             <option value="all" <?php if(compareValues($app->settings->board_card_who_transition_partner_link, "all")){ echo 'selected=""'; } ?> ><?php echo translate("tr_984bf1497dea9513aa66cf7b0e1eeb0e"); ?></option>
           </select>  
     
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_ad51225e2ef05117a709b83a87d45440"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_e94dd4d503f0607073a52c1172db634d"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

           <select name="board_catalog_ad_view" class="form-select selectpicker" >
             <option value="grid" <?php if(compareValues($app->settings->board_catalog_ad_view, "grid")){ echo 'selected=""'; } ?> ><?php echo translate("tr_27c4a166039bc4b0ff6e414ff8dbe752"); ?></option>
             <option value="list" <?php if(compareValues($app->settings->board_catalog_ad_view, "list")){ echo 'selected=""'; } ?> ><?php echo translate("tr_f57a57801816cda516533de4183a990a"); ?></option>
           </select>  
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_6f797644aa91a340e2b1f51400176529"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <div class="input-group">
            <input type="number" name="board_catalog_height_item" class="form-control" value="<?php echo $app->settings->board_catalog_height_item; ?>" >  
            <span class="input-group-text">px</span>
          </div>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_9bc59e83e1fbb78f11e36ac3ebbf53b8"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

           <select name="board_catalog_ad_option_opening" class="form-select selectpicker" >
             <option value="current" <?php if(compareValues($app->settings->board_catalog_ad_option_opening, "current")){ echo 'selected=""'; } ?> ><?php echo translate("tr_4fb217eb749533d96eb7cf691b583e9d"); ?></option>
             <option value="blank" <?php if(compareValues($app->settings->board_catalog_ad_option_opening, "blank")){ echo 'selected=""'; } ?> ><?php echo translate("tr_126aa1548ba84d2e72b4698cb8cb90d6"); ?></option>
           </select>  
     
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_342a6611d9bae58f896d18c53683b85a"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <input type="number" name="out_default_count_items" class="form-control" value="<?php echo $app->settings->out_default_count_items; ?>" >

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_54b79668cdda61ede86e84be0f5ef551"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <input type="number" name="out_default_count_city_distance_items" class="form-control" value="<?php echo $app->settings->out_default_count_city_distance_items; ?>" >

        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_fdd3ab8201fd27f55600ee81d29a560c"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <div class="input-group">
            <input type="number" name="board_ads_geo_distance" class="form-control" value="<?php echo $app->settings->board_ads_geo_distance; ?>" >  
            <span class="input-group-text"><?php echo translate("tr_181b4f8a00ba4244af2f3e89f2a8bb34"); ?></span>
          </div>

        </div>
      </div>

    </div>

  </div>


</div>
</div>

</div>

