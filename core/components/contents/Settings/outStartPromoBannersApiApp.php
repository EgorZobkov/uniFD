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