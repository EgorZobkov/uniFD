<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-api-app-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_nav_bar_label_status" value="1" class="switch-input" <?php if($app->settings->api_app_nav_bar_label_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_c5dea20f996084905115ff91a5e9bf58"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_fortune_bonus_status" value="1" class="switch-input" <?php if($app->settings->api_app_fortune_bonus_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_8079f64db75b7a781f92c944ffca629d"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_21e338f2639581c84ba9f4727c693e0c"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >       
          <input type="text" name="api_app_fortune_bonus_items" class="form-control" value="<?php echo $app->settings->api_app_fortune_bonus_items; ?>" >
        </div>
      </div>

      <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert">
          <?php echo translate("tr_548d6d3c91a652a7c44f50bd778ae78c"); ?>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_51bdf506a38780e9ba340faee48294b8"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >       
          <input type="text" name="api_app_project_name" class="form-control" value="<?php echo $app->settings->api_app_project_name; ?>" >
        </div>
      </div>

      <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert"><?php echo translate("tr_8957724a44c5077d4bd6d83a8401527d"); ?></div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_303cb092bf1e1bbb345e5d3e53e7d43f"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >       
          <input type="text" name="api_app_user_agreement_link" class="form-control" value="<?php echo $app->settings->api_app_user_agreement_link; ?>" >
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_2336b5368642172948377e9fbb2611ff"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >       
          <input type="text" name="api_app_privacy_policy_link" class="form-control" value="<?php echo $app->settings->api_app_privacy_policy_link; ?>" >
        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_fc0b3dd14b73a1b1e6170ba3ebbbd0d1"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >       
          <input type="text" name="api_app_replenishment_balance_amount_list" class="form-control" value="<?php echo $app->settings->api_app_replenishment_balance_amount_list; ?>" >
        </div>
      </div>

      <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert">
          <?php echo translate("tr_8922458b70785c15dbc0f0159cd97671"); ?>
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

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_catalog_item_card[ad_rating_status]" value="1" class="switch-input" <?php if($app->settings->api_app_catalog_item_card['ad_rating_status']){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_b3946f7aac5bae764db2452601687f6c"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_catalog_item_card[user_avatar_status]" value="1" class="switch-input" <?php if($app->settings->api_app_catalog_item_card['user_avatar_status']){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_eb6efcc5f05aa2d36ada1300f41e0087"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_catalog_item_card[city_status]" value="1" class="switch-input" <?php if($app->settings->api_app_catalog_item_card['city_status']){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_ae93c6f38aef64e9c759f6a10ebf1438"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row">
        <div class="col-12 col-md-6">

          <label class="switch">
            <input type="checkbox" name="api_app_catalog_item_card[time_create_status]" value="1" class="switch-input" <?php if($app->settings->api_app_catalog_item_card['time_create_status']){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_5ecaf28dbc5b685e79953a2ea3886330"); ?></span>
          </label>

        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_6f797644aa91a340e2b1f51400176529"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

          <input type="number" name="api_app_catalog_item_card[height_item_photo]" class="form-control" value="<?php echo $app->settings->api_app_catalog_item_card['height_item_photo']; ?>">  

        </div>
      </div>

    </div>

    <div class="col-12 mt-0">

      <label class="form-label mb-2"><?php echo translate("tr_325532d44d6117dc760b247f55505309"); ?></label>

      <div class="row">
        <div class="col-12 col-md-6">

          <input type="number" name="api_app_catalog_item_card[height_default_card]" class="form-control" value="<?php echo $app->settings->api_app_catalog_item_card['height_default_card']; ?>">  

        </div>
      </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_dbf2fcc8d96e960a90917b8733fbd804"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_section_download_status" value="1" class="switch-input" <?php if($app->settings->api_app_section_download_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_1e4bfa7b4e4484edec51a51fe74f9281"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_download_only_apk" value="1" class="switch-input" <?php if($app->settings->api_app_download_only_apk){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_aae8e0e2df2ca960b084a867e96d9dd6"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="settings-api-app-apk-link-container" <?php if($app->settings->api_app_download_only_apk){ echo 'style="display:block"'; } ?> >
      <div class="col-12 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_188f7b459e854a4898472044c30f84b6"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="api_app_download_link_apk" class="form-control" value="<?php echo $app->settings->api_app_download_link_apk; ?>" >     
            <label class="form-label-error" data-name="api_app_download_link_apk" ></label>   
          </div>
        </div>

      </div>
    </div>

    <div class="settings-api-app-download-links-container" <?php if(!$app->settings->api_app_download_only_apk){ echo 'style="display:block"'; } ?> >
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_79555a44d9cb877251c23e5d39575681"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="api_app_download_links[play_market]" class="form-control" value="<?php echo $app->settings->api_app_download_links["play_market"]; ?>" >        
          </div>
        </div>

      </div>
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_0f56e3153b815aca8d97d79e298c7496"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="api_app_download_links[app_store]" class="form-control" value="<?php echo $app->settings->api_app_download_links["app_store"]; ?>" >        
          </div>
        </div>

      </div>
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_88b0d26ca402f2f6e9267413a2c4ff72"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="api_app_download_links[app_gallery]" class="form-control" value="<?php echo $app->settings->api_app_download_links["app_gallery"]; ?>" >        
          </div>
        </div>

      </div>
      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_4a486afa64c3d214a96ac7b81b50d17e"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >
            <input type="text" name="api_app_download_links[ru_store]" class="form-control" value="<?php echo $app->settings->api_app_download_links["ru_store"]; ?>" >        
          </div>
        </div>

      </div>            
    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_48542d20ff3512a40df77e3f96c5c62e"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_2a8b186e2d60f4718467bfc0e367706b"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-12" >    
            <textarea class="form-control" name="api_app_firebase_push_params" rows="6" ><?php echo $app->settings->api_app_firebase_push_params ? decrypt($app->settings->api_app_firebase_push_params) : ''; ?></textarea>   
          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_f9668688654527e4935b9acba66967c7"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_3bcfa2e5395df6285c87cb1ed4299fff"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >       
            <input type="text" name="api_app_metrica_key" class="form-control" value="<?php echo $app->settings->api_app_metrica_key; ?>" >
          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_782945aa48d9ffabf06aad9d913b16be"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mt-0 mb-3">

        <label class="form-label mb-2" ><?php echo translate("tr_e1228efa56c6d4ecd5b146dc12b11e69"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >    

            <div class="settings-api-app-page-out-content-container" id="settings-api-app-page-out-content-container" >
              <?php echo $app->component->settings->outMainPageContentApiApp(); ?>
            </div>

          </div>
        </div>

      </div>

      <div class="col-12 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_d7e1362036003e74266d5c8a1ee01712"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >    
            <select class="selectpicker" name="api_app_main_page_tabs[]" multiple="" title="tr_591cca300870eb571563ef4b8c8756ff" >
               <option value="recommendations" <?php if(compareValues($app->settings->api_app_main_page_tabs, "recommendations")){ echo 'selected=""'; } ?> ><?php echo translate("tr_558e9d04ead7e5b7039047030e62c975"); ?></option>
               <option value="fresh" <?php if(compareValues($app->settings->api_app_main_page_tabs, "fresh")){ echo 'selected=""'; } ?> ><?php echo translate("tr_d545c294521a0519bfda49831cf19230"); ?></option>
               <option value="shops" <?php if(compareValues($app->settings->api_app_main_page_tabs, "shops")){ echo 'selected=""'; } ?> ><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></option>
            </select>
          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_915b2c5891fc54677e4bb5b31beb1667"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >       
            <input type="text" name="api_app_main_page_registration_box[title]" class="form-control" value="<?php echo $app->settings->api_app_main_page_registration_box["title"]; ?>" >
          </div>
        </div>

      </div>

      <div class="col-12 mb-3 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >       
            <input type="text" name="api_app_main_page_registration_box[text]" class="form-control" value="<?php echo $app->settings->api_app_main_page_registration_box["text"]; ?>" >
          </div>
        </div>

      </div>

      <div class="col-12 mt-0">

        <label class="form-label mb-2" ><?php echo translate("tr_22d1dda712935d6813ba898faae4aa59"); ?></label>

        <div class="row" >
          <div class="col-12 col-md-6" >       
            <input type="text" name="api_app_main_page_registration_box[button_text]" class="form-control" value="<?php echo $app->settings->api_app_main_page_registration_box["button_text"]; ?>" >
          </div>
        </div>

      </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_c777df59fdac8c95f698ebf6f9c3bc4f"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">
      
      <span class="btn btn-sm btn-primary waves-effect waves-light settingsApiAppServicesPagesAdd mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

    <div class="col-12 mt-0">

        <div class="settings-api-app-services-pages-container" >
            <?php echo $app->component->settings->outServicesPagesApiApp(); ?>
        </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_1a8ad8f4d957bc7172b26c3aca4723d7"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_main_page_promo_sections_status" value="1" class="switch-input" <?php if($app->settings->api_app_main_page_promo_sections_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_2c59adaafc2c86b362c2b67ee91ba5f6"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >    
          <select class="selectpicker" name="api_app_main_page_promo_sections_view" >
             <option value="icon_name" <?php if(compareValues($app->settings->api_app_main_page_promo_sections_view, "icon_name")){ echo 'selected=""'; } ?> ><?php echo translate("tr_63a9f6e34cca17cf6cef6a621116f637"); ?></option>
             <option value="name" <?php if(compareValues($app->settings->api_app_main_page_promo_sections_view, "name")){ echo 'selected=""'; } ?> ><?php echo translate("tr_e52a37d9a87c69681d5b40e88b9b2f49"); ?></option>
          </select>
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">
      
      <span class="btn btn-sm btn-primary waves-effect waves-light settingsApiAppPromoSectionsAdd mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

    <div class="col-12 mt-0">

        <div class="settings-api-app-promo-sections-container" >
            <?php echo $app->component->settings->outPromoSectionsApiApp(); ?>
        </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_cfcdfc2b74c795aba26cacb282b40fa1"); ?></h3>
</div>
<div class="card-body">

  <div class="alert alert-primary d-flex align-items-center mb-3" role="alert">
      <?php echo translate("tr_029d89ae7fcfe97cbac84089eba6a526"); ?>
  </div>

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_main_page_slider_banners_status" value="1" class="switch-input" <?php if($app->settings->api_app_main_page_slider_banners_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">
      
      <span class="btn btn-sm btn-primary waves-effect waves-light settingsApiAppSliderBannerAdd mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

    <div class="col-12 mt-0">

        <div class="settings-api-app-slider-banners-container" >
            <?php echo $app->component->settings->outSliderBannersApiApp(); ?>
        </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_e969568c61eedffd77b4aa546a515f63"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_main_page_header_banner_status" value="1" class="switch-input" <?php if($app->settings->api_app_main_page_header_banner_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >      
          <label class="form-label mb-2"><?php echo translate("tr_b87eae9ed7afc4de539846d81943a94c"); ?></label> 
          <input type="text" name="api_app_main_page_header_banner[target]" class="form-control" value="<?php echo $app->settings->api_app_main_page_header_banner["target"]; ?>" >
        </div>

        <div class="col-12 col-md-6" >   
          <label class="form-label mb-2"><?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?></label>    
          <input type="text" name="api_app_main_page_header_banner[image_link]" class="form-control" value="<?php echo $app->settings->api_app_main_page_header_banner["image_link"]; ?>" >
        </div>        
      </div>

    </div>

    <div class="col-12 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >      
          <label class="form-label mb-2"><?php echo translate("tr_c83f319d2a6021a184e02721e9d3cd20"); ?></label> 
          <input type="number" name="api_app_main_page_header_banner[height]" class="form-control" value="<?php echo $app->settings->api_app_main_page_header_banner["height"]; ?>" >
        </div>        
      </div>

    </div>

  </div>

</div>
</div>

<div class="card">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_02c24519ddbcc60719a15ef6e1117939"); ?></h3>
</div>
<div class="card-body">

  <div class="alert alert-primary d-flex align-items-center mb-3" role="alert">
      <?php echo translate("tr_a52715f90f6efd3311a2c05550d91777"); ?>
  </div>

  <div class="row">

    <div class="col-12 mb-3 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="api_app_start_promo_banners_status" value="1" class="switch-input" <?php if($app->settings->api_app_start_promo_banners_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

    <div class="col-12 mb-3 mt-0">
      
      <span class="btn btn-sm btn-primary waves-effect waves-light settingsApiAppStartBannerAdd mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>

    </div>

    <div class="col-12 mt-0">

        <div class="settings-api-app-start-banners-container" >
            <?php echo $app->component->settings->outStartPromoBannersApiApp(); ?>
        </div>

    </div>

  </div>

</div>
</div>

</div>
