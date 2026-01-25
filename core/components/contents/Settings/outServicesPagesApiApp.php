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