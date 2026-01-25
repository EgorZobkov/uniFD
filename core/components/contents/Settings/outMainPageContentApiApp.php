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