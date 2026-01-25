public function outBookingAdditionalServicesInCreate($data=[]){
    global $app;

    if($data){

        foreach ($data as $key => $value) {

            ?>
            <div class="ad-create-options-additional-services-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="text" name="booking_additional_services[<?php echo $key; ?>][name]" class="form-control" value="<?php echo $value["name"]; ?>" placeholder="<?php echo translate("tr_45a4c11809990f3313f8f38748db27df"); ?>" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_additional_services[<?php echo $key; ?>][price]" class="form-control" value="<?php echo $value["price"]; ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-additional-services-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
            <?php

        }

    }

}