<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-profile-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_aa1fb4ede6183f64c46ac2275ccdd411"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_bec6a04713c99f9c3fc52df62082b897"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="registration_authorization_method" >
              <option value="email-phone" <?php if(compareValues($app->settings->registration_authorization_method,"email-phone")){ echo 'selected=""'; } ?> ><?php echo translate("tr_a5dcac2a4d2713ceb3087b1ed31acf3d"); ?></option>
              <option value="phone" <?php if(compareValues($app->settings->registration_authorization_method,"phone")){ echo 'selected=""'; } ?> ><?php echo translate("tr_ee27c3edd00706e4aaca3226e0934613"); ?></option>
              <option value="email" <?php if(compareValues($app->settings->registration_authorization_method,"email")){ echo 'selected=""'; } ?> ><?php echo translate("tr_748050c9a95f78513127f681a5357d25"); ?></option>
              <option value="services" <?php if(compareValues($app->settings->registration_authorization_method,"services")){ echo 'selected=""'; } ?> ><?php echo translate("tr_f8bcf3814db1a919e8e5c0cd7ac6cbf6"); ?></option>
            </select>          
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_21064f36c736e877b0dbd6836033f62e"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <select class="form-select selectpicker" name="registration_authorization_view" >
              <option value="combined" <?php if(compareValues($app->settings->registration_authorization_view,"combined")){ echo 'selected=""'; } ?> ><?php echo translate("tr_e649c1ce7afd8b5c7dd599035ccbb9a3"); ?></option>
              <option value="separate" <?php if(compareValues($app->settings->registration_authorization_view,"separate")){ echo 'selected=""'; } ?> ><?php echo translate("tr_b3704e9489ae5acdb9af7cdbdf63edee"); ?></option>
              <option value="services" <?php if(compareValues($app->settings->registration_authorization_view,"services")){ echo 'selected=""'; } ?> ><?php echo translate("tr_9404722ae618b8d1e1a101a39ad005bd"); ?></option>
            </select>          
        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_d2ed721d0c08f9f114598a084f24c784"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

        <label class="switch">
          <input type="checkbox" name="profile_notifications_messenger_status" value="1" class="switch-input" <?php if($app->settings->profile_notifications_messenger_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_dd401336899d15c49abfdf2ab008ae94"); ?></span>
        </label>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_419a0c4f19223bbef8fd1cbf92bf0cd0"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="profile_wallet_status" value="1" class="switch-input" <?php if($app->settings->profile_wallet_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_419a0c4f19223bbef8fd1cbf92bf0cd0"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_988d98b51cc38f2f2aa5ff7d44f7bd17"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" class="form-control" name="profile_wallet_min_amount_replenishment" value="<?php echo $app->settings->profile_wallet_min_amount_replenishment; ?>" step="0.01" >
              <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
            </div>

        </div>
      </div>

    </div>    

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_e146ab50b7fbe6127658d58c417c54c4"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" class="form-control" name="profile_wallet_max_amount_replenishment" value="<?php echo $app->settings->profile_wallet_max_amount_replenishment; ?>" step="0.01" >
              <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
            </div>

        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_8d84a0cdf8be0221a8f814a68ef43b98"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="registration_bonus_status" value="1" class="switch-input" <?php if($app->settings->registration_bonus_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
        </label>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_12956a703ee019867c6aa99b070cdc65"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" class="form-control" name="registration_bonus_amount" value="<?php echo $app->settings->registration_bonus_amount; ?>" step="0.01" >
              <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
            </div>

        </div>
      </div>

    </div>    

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_af290a256ca664b10c4fd61c9534c635"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="referral_program_status" value="1" class="switch-input" <?php if($app->settings->referral_program_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_047e75c532cfc056f40ed8e8ae5d62f5"); ?></span>
        </label>

    </div>    

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_05a7da8ca9aae3484e4829e862ea11f1"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

            <div class="input-group">
              <input type="number" class="form-control" name="referral_program_percent_award" value="<?php echo $app->settings->referral_program_percent_award; ?>" step="0.01" >
              <span class="input-group-text">%</span>
            </div>

        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_c7cadea1c393b4b40ed898d48f10c1b0"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="verification_users_status" value="1" class="switch-input" <?php if($app->settings->verification_users_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_fbd456ddcd7e010905cbb877fc1253e3"); ?></span>
        </label>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_438bab17a372fae912887f27a9107094"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <select class="form-select selectpicker" name="verification_users_permissions[]" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
            <?php echo $app->component->settings->outSystemsVerificationUsersPermissions(); ?>
          </select>

        </div>
      </div>

    </div>    

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_8b1d96f8de04890d0139a4ced65111b8"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="shop_moderation_status" value="1" class="switch-input" <?php if($app->settings->shop_moderation_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_424b696a1620af969ab9890f366df30d"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_d28b43096f69ea7188dc5f1dc5256fa2"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

          <input type="number" name="shop_max_banners" class="form-control" value="<?php echo $app->settings->shop_max_banners; ?>">

        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_12b87dfdc29ff9adf52f0cb3a5b41709"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

          <input type="number" name="shop_max_pages" class="form-control" value="<?php echo $app->settings->shop_max_pages; ?>">

        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_b84af1c46baa36df4513d427a6e0715a"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

        <label class="switch">
          <input type="checkbox" name="stories_moderation_status" value="1" class="switch-input" <?php if($app->settings->stories_moderation_status){ echo 'checked=""'; } ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_424b696a1620af969ab9890f366df30d"); ?></span>
        </label>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_9c30925ddb87c1592e1fc863b1216449"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

            <div class="input-group">
              <input type="number" class="form-control" name="stories_period_placement" value="<?php echo $app->settings->stories_period_placement; ?>" >
              <span class="input-group-text"><?php echo translate("tr_d743980ad205b434efc9bd4f46b89f43"); ?></span>
            </div>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_da64c3d2aebe085e37b81de2b8f291d6"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

            <div class="input-group">
              <input type="number" name="stories_max_size_image" class="form-control" value="<?php echo $app->settings->stories_max_size_image; ?>">
              <span class="input-group-text"><?php echo translate("tr_505c12388f06a422b00aa0ac07de72c5"); ?></span>
            </div>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_9ae516c38adb35538122d6c0ac3d98f0"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

            <div class="input-group">
              <input type="number" name="stories_max_size_video" class="form-control" value="<?php echo $app->settings->stories_max_size_video; ?>">
              <span class="input-group-text"><?php echo translate("tr_505c12388f06a422b00aa0ac07de72c5"); ?></span>
            </div>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_88a1ba354a0552544236e8844b1a92d5"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

            <div class="input-group">
              <input type="number" name="stories_max_duration_image" class="form-control" value="<?php echo $app->settings->stories_max_duration_image; ?>">
              <span class="input-group-text"><?php echo translate("tr_ccaa89f9bc459f1812820ab348acc23e"); ?></span>
            </div>

        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_52442ed04c70f4e79a230af5c5b53a0c"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

            <div class="input-group">
              <input type="number" name="stories_max_duration_video" class="form-control" value="<?php echo $app->settings->stories_max_duration_video; ?>">
              <span class="input-group-text"><?php echo translate("tr_ccaa89f9bc459f1812820ab348acc23e"); ?></span>
            </div>

        </div>
      </div>

    </div>

  </div>

</div>
</div>

</div>
