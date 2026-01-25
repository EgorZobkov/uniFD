<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Settings
{

 public $alias = "settings";

 public function getActivePaymentServices(){
    global $app;
    return $app->model->system_payment_services->sort("id desc")->getAll("status=?", [1]);
}

public function getAllPaymentServices(){
    global $app;
    return $app->model->system_payment_services->sort("id desc")->getAll();
}

public function getFontsWatermark(){
    global $app;

    $fonts = glob($app->config->storage->fonts.'/*.ttf');

    if($fonts){
        foreach ($fonts as $file){
            $basename = getInfoFile($file)->basename;
            if($app->settings->watermark_title_font == $basename){
                echo '<option value="'.$basename.'" selected="" >'.$basename.'</option>';
            }else{
                echo '<option value="'.$basename.'" >'.$basename.'</option>';
            }
        }
    }
}

public function getFrontendHomeWidgets(){
    global $app;

    return $app->model->frontend_home_widgets->sort("sorting asc")->getAll("status=?", [1]);

}

public function getSections(){
    global $app;
    return $app->model->system_settings_sections->sort("sorting asc")->getAll();
}

public function getSmtpServices(){
    global $app;
    return $app->model->system_smtp_services->sort("id desc")->getAll();
}

public function getSystemNotifyList($user_id=0){
    global $app;

    $list = [];

    if($user_id){
        $getNotify = $app->model->users_notify_list->getAll("user_id=?", [$user_id]);
        if($getNotify){
            foreach ($getNotify as $key => $value) {
                $list[] = $value["action_code"];
            }
        }
    }

    $getNotifyList = $app->notify->actionsCodeSystem();

    if($getNotifyList){
      foreach ($getNotifyList as $value) {
        ?>
        <option value="<?php echo $value["code"]; ?>" <?php if(compareValues($list, $value["code"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
        <?php
      }
    }

}

public function getSystemsCurrencies(){
    global $app;

    if($app->config->currency){
        foreach ($app->config->currency as $key => $value){
            if($app->settings->system_default_currency == $key){
                echo '<option value="'.$key.'" selected="" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }else{
                echo '<option value="'.$key.'" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }
        }            
    }

}

public function getSystemsExtraCurrencies(){
    global $app;

    if($app->config->currency){
        foreach ($app->config->currency as $key => $value){
            if(compareValues($app->settings->system_extra_currency, $key)){
                echo '<option value="'.$key.'" selected="" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }else{
                echo '<option value="'.$key.'" >'.$value->name.' ('.$value->symbol_native.')</option>';
            }
        }            
    }

}

public function getSystemsTimezone(){
    global $app;

    if($app->config->timezone){
        foreach ($app->config->timezone as $key => $value){
            if($app->settings->system_timezone == $key){
                echo '<option value="'.$key.'" selected="" >'.$key.'</option>';
            }else{
                echo '<option value="'.$key.'" >'.$key.'</option>';
            }
        }            
    }

}

public function outContactSocialLinks(){
    global $app;

    if($app->settings->contact_social_links){
        foreach ($app->settings->contact_social_links as $key => $value) {
            ?>

            <div class="col-12 mb-2 contact-social-link-item">

              <div class="row" >
                <div class="col-12 col-md-3 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][name]" class="form-control" placeholder="<?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?>" value="<?php echo $value["name"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-4 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][link]" class="form-control" placeholder="<?php echo translate("tr_9797b9494600869ec6a941dae3f2a198"); ?>" value="<?php echo $value["link"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-4 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][image]" class="form-control" placeholder="<?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?>" value="<?php echo $value["image"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-1" >
                  <span class="btn btn-icon btn-label-danger waves-effect settingsInformationDeleteSocialLink"><i class="ti ti-trash"></i></span> 
                </div>
              </div>

            </div>

            <?php
        }
    }

}

public function outDeliveryServicesListEdit(){
    global $app;

    $data = $app->model->system_delivery_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-delivery-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->delivery($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}

public function outDeliveryServicesOptions(){
    global $app;

    $data = $app->model->system_delivery_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->integration_delivery_services_active, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}

public function outFrontendHomeWidgetsItem(){
    global $app;

    $result = $app->model->frontend_home_widgets->sort("sorting asc")->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($value["status"]){
                echo '
                <div class="settings-home-widgets-sortable-handle" >
                <label class="switch">
                  <input type="checkbox" name="frontend_home_visible_widgets_active['.$value["code"].']" value="1" class="switch-input" checked >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">'.translateField($value["name"]).'</span>
                </label>
                <input type="hidden" name="frontend_home_visible_widgets['.$value["code"].']" />
                </div>';
            }else{
                echo '
                <div class="settings-home-widgets-sortable-handle" >
                <label class="switch">
                  <input type="checkbox" name="frontend_home_visible_widgets_active['.$value["code"].']" value="1" class="switch-input" >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">'.translateField($value["name"]).'</span>
                </label>
                <input type="hidden" name="frontend_home_visible_widgets['.$value["code"].']" />
                </div>';
            }
        }
    }

}

public function outMainPageContentApiApp(){
    global $app;

    $data = [
        "main_categories"=>translate("tr_67342ab09ccc55889193ab82d44b4be1"),
        "stories"=>translate("tr_fed7d9e3299ef32e3d13607e543e0245"),
        "box_registration"=>translate("tr_915b2c5891fc54677e4bb5b31beb1667"),
        "promo_banners"=>translate("tr_369c5894a00530143785ee61375995ea"),
        "promo_sections"=>translate("tr_1a8ad8f4d957bc7172b26c3aca4723d7"),
    ];

    if($app->settings->api_app_main_page_out_content){

        foreach ($app->settings->api_app_main_page_out_content as $key => $nested) {
            foreach ($nested as $code => $value) {
                if($value){
                    echo '
                    <div class="settings-api-app-page-out-content-sortable-handle" >
                    <label class="switch">
                      <input type="checkbox" name="api_app_main_page_out_content['.$code.']" value="1" class="switch-input" checked >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.$data[$code].'</span>
                    </label>
                    <input type="hidden" name="api_app_main_page_out_content_all[]" value="'.$code.'" />
                    </div>';
                }else{
                    echo '
                    <div class="settings-api-app-page-out-content-sortable-handle" >
                    <label class="switch">
                      <input type="checkbox" name="api_app_main_page_out_content['.$code.']" value="1" class="switch-input" >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.$data[$code].'</span>
                    </label>
                    <input type="hidden" name="api_app_main_page_out_content_all[]" value="'.$code.'" />
                    </div>';
                }
            }
        }

    }else{

        foreach ($data as $key => $value) {
            echo '
            <div class="settings-api-app-page-out-content-sortable-handle" >
            <label class="switch">
              <input type="checkbox" name="api_app_main_page_out_content['.$key.']" value="1" class="switch-input" >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label">'.$value.'</span>
            </label>
            <input type="hidden" name="api_app_main_page_out_content_all[]" value="'.$key.'" />
            </div>';
        }

    }

}

public function outMessengerServicesListEdit(){
    global $app;

    $data = $app->model->system_messenger_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-messenger-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->messenger($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}

public function outMessengerServicesOptions(){
    global $app;

    $data = $app->model->system_messenger_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->integration_messenger_service, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}

public function outOAuthServicesListEdit(){
    global $app;

    $data = $app->model->system_oauth_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-oauth-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->oauth($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}

public function outOAuthServicesOptions(){
    global $app;

    $data = $app->model->system_oauth_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->auth_services_list, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}

public function outPaymentServicesListEdit(){
    global $app;

    $getAllPaymentServices = $this->getAllPaymentServices();

    if($getAllPaymentServices){
        foreach ($getAllPaymentServices as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-payment-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->payment($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}

public function outPromoSectionsApiApp(){
    global $app;

    if($app->settings->api_app_main_page_promo_sections){

        foreach ($app->settings->api_app_main_page_promo_sections as $key => $value) {
            ?>

                <div class="bg-lighter rounded p-3 position-relative settings-api-app-promo-sections-item mb-2">

                  <div class="row" >
                    
                    <div class="col-md-4" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_e52a37d9a87c69681d5b40e88b9b2f49"); ?></label>

                        <input type="text" name="api_app_main_page_promo_sections[<?php echo $key; ?>][name]" class="form-control" value="<?php echo $value["name"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-4" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_b87eae9ed7afc4de539846d81943a94c"); ?></label>

                        <input type="text" name="api_app_main_page_promo_sections[<?php echo $key; ?>][target]" class="form-control" value="<?php echo $value["target"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-4" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?></label>

                        <input type="text" name="api_app_main_page_promo_sections[<?php echo $key; ?>][image_link]" class="form-control" value="<?php echo $value["image_link"]; ?>"> 
                      </div>              
                      
                    </div>

                  </div>

                  <div class="text-end" >
                    <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppPromoSectionsDelete"><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                  </div>

                </div>

            <?php
        }

    }

}

public function outSectionContent(){
    global $app;
    if($app->router->currentRoute->name == "dashboard-settings"){
        $section = $app->model->system_settings_sections->sort("sorting asc")->find("default_section=?", [1]);
    }else{
        $section = $app->model->system_settings_sections->sort("sorting asc")->find("route_name=?", [$app->router->currentRoute->name]);
    }
    return $app->view->includeComponent("settings/{$section->section_id}.tpl");
}

public function outSections(){
    global $app;

    $getSections = $this->getSections();
    
    if($getSections){
        foreach ($getSections as $value) {
           ?>

            <li class="nav-item mb-1">
              <a class="nav-link py-2 <?php if($app->router->currentRoute->name == "dashboard-settings"){ if($value["default_section"]){ echo 'active'; } }else{ if($app->router->currentRoute->name == $value["route_name"]){ echo 'active'; } } ?>" href="<?php echo $app->router->getRoute($value["route_name"]); ?>">
                <i class="ti <?php echo $value["icon"]; ?> me-2"></i>
                <span class="align-middle"><?php echo translateField($value["name"]); ?></span>
              </a>
            </li>

           <?php
        }
    }

}

public function outServicesPagesApiApp(){
    global $app;

    if($app->settings->api_app_services_pages){

        foreach ($app->settings->api_app_services_pages as $key => $value) {
            ?>

                <div class="bg-lighter rounded p-3 position-relative settings-api-app-services-pages-item mb-2">

                  <div class="row" >
                    
                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_e52a37d9a87c69681d5b40e88b9b2f49"); ?></label>

                        <input type="text" name="api_app_services_pages[<?php echo $key; ?>][name]" class="form-control" value="<?php echo $value["name"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_b87eae9ed7afc4de539846d81943a94c"); ?></label>

                        <input type="text" name="api_app_services_pages[<?php echo $key; ?>][target]" class="form-control" value="<?php echo $value["target"]; ?>">
                      </div>              

                    </div>

                  </div>

                  <div class="text-end" >
                    <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppServicesPagesDelete"><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                  </div>

                </div>

            <?php
        }

    }

}

public function outSliderBannersApiApp(){
    global $app;

    if($app->settings->api_app_main_page_slider_banners){

        foreach ($app->settings->api_app_main_page_slider_banners as $key => $value) {
            ?>

                <div class="bg-lighter rounded p-3 position-relative settings-api-app-slider-banners-item mb-2">

                  <div class="row" >
                    
                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_b87eae9ed7afc4de539846d81943a94c"); ?></label>

                        <input type="text" name="api_app_main_page_slider_banners[<?php echo $key; ?>][target]" class="form-control" value="<?php echo $value["target"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?></label>

                        <input type="text" name="api_app_main_page_slider_banners[<?php echo $key; ?>][image_link]" class="form-control" value="<?php echo $value["image_link"]; ?>"> 
                      </div>              
                      
                    </div>

                  </div>

                  <div class="text-end" >
                    <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppSliderBannerDelete"><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                  </div>

                </div>

            <?php
        }

    }

}

public function outSmsServicesOptions($action=null){
    global $app;

    $data = $app->model->system_sms_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" data-alias="<?php echo $value["alias"]; ?>" <?php if($app->settings->integration_sms_service == $value["id"]){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}

public function outStartPromoBannersApiApp(){
    global $app;

    if($app->settings->api_app_start_promo_banners){

        foreach ($app->settings->api_app_start_promo_banners as $key => $value) {
            ?>

                <div class="bg-lighter rounded p-3 position-relative settings-api-app-start-banners-item mb-2">

                  <div class="row" >
                    
                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label>

                        <input type="text" name="api_app_start_promo_banners[<?php echo $key; ?>][title]" class="form-control" value="<?php echo $value["title"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?></label>

                        <input type="text" name="api_app_start_promo_banners[<?php echo $key; ?>][image_link]" class="form-control" value="<?php echo $value["image_link"]; ?>"> 
                      </div>              
                      
                    </div>

                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_544cca5cb61dcdd02a248f8062dc2957"); ?></label>

                        <input type="text" name="api_app_start_promo_banners[<?php echo $key; ?>][color_bg]" class="form-control minicolors-input" value="<?php echo $value["color_bg"]; ?>">
                      </div>              

                    </div>

                    <div class="col-md-6" >
                      
                      <div class="mb-2">
                        <label class="form-label mb-2"><?php echo translate("tr_8bb4a3e13a130f6b9311d47a89291f3b"); ?></label>

                        <input type="text" name="api_app_start_promo_banners[<?php echo $key; ?>][color_text]" class="form-control minicolors-input" value="<?php echo $value["color_text"]; ?>"> 
                      </div>              
                      
                    </div>

                  </div>

                  <div>
                    <label class="form-label mb-2"><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>

                    <div class="row">
                      <div class="col-12 col-md-12"> 
                        <textarea class="form-control" name="api_app_start_promo_banners[<?php echo $key; ?>][text]" rows="4" ><?php echo $value["text"]; ?></textarea>
                      </div>
                    </div>

                  </div>

                  <div class="text-end" >
                    <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppStartBannerDelete mt-2"><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                  </div>

                </div>

            <?php
        }

    }

}

public function outSystemsPriceMeasurements($view=null, $ids=null){
    global $app;

    $result = $app->model->system_measurements->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($view == "option"){
                if($ids && is_array(_json_decode($ids))){
                    if(compareValues(_json_decode($ids),$value["id"])){
                        echo '<option value="'.$value["id"].'" selected="" >'.translateField($value["name"]).'</option>';
                    }else{
                        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                    }
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                }
            }else{
                echo '<div class="settings-system-measurement-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_measurement[update]['.$value["id"].']" value="'.translateField($value["name"]).'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemMeasurement"><i class="ti ti-trash"></i></span></div></div></div>';                    
            }
        }
    }

}

public function outSystemsPriceNames($view=null, $id=0){
    global $app;

    $result = $app->model->system_price_names->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($view == "option"){
                if($id){
                    if($id == $value["id"]){
                        echo '<option value="'.$value["id"].'" selected="" >'.translateField($value["name"]).'</option>';
                    }else{
                        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                    }
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                }
            }else{
                echo '<div class="settings-system-price-names-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_price_names[update]['.$value["id"].']" value="'.translateField($value["name"]).'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemPriceNames"><i class="ti ti-trash"></i></span></div></div></div>';
            }
        }
    }

}

public function outSystemsVerificationUsersPermissions(){
    global $app;

    $result = $app->model->system_verification_users_permissions->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if(compareValues($app->settings->verification_users_permissions,$value["code"])){
                echo '<option value="'.$value["code"].'" selected="" >'.translateField($value["name"]).'</option>';
            }else{
                echo '<option value="'.$value["code"].'" >'.translateField($value["name"]).'</option>';
            }
        }
    }

}

public function outUsersOnlyAdminOptions(){
    global $app;

    $data = $app->model->users->sort("id desc")->getAll("admin=?", [1]);

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->system_report_recipients_ids, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $app->user->name($value); ?></option>
          <?php
        }
    }

}



}