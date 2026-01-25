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