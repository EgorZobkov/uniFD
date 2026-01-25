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