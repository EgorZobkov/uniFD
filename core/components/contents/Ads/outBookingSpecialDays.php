public function outBookingSpecialDays($data=[]){
    global $app;

    if($data){

        foreach ($data as $key => $value) {

            ?>
            <div class="ad-create-options-special-days-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="date" name="booking_special_days[<?php echo $key; ?>][date]" class="form-control" value="<?php echo $value["date"]; ?>" placeholder="<?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?>" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_special_days[<?php echo $key; ?>][price]" class="form-control" value="<?php echo $value["price"]; ?>" placeholder="<?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?>" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-special-days-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
            <?php

        }

    }        

}