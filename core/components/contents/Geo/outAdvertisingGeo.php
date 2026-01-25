public function outAdvertisingGeo($geo=[]){
    global $app;

    if($geo){
         foreach (_json_decode($geo) as $purpose => $nested) {
           foreach ($nested as $key => $value) {
             if($purpose == "city"){
                 $geo = $app->model->geo_cities->find("id=?", [$value]);
             }elseif($purpose == "region"){
                 $geo = $app->model->geo_regions->find("id=?", [$value]);
             }elseif($purpose == "country"){
                 $geo = $app->model->geo_countries->find("id=?", [$value]);
             }
             ?>
             <div class="advertising-geo-inputs-item" > <span class="advertising-geo-inputs-item-delete" ><i class="ti ti-trash"></i></span> <input type="hidden" name="geo[<?php echo $purpose; ?>][]" value="<?php echo $geo->id; ?>" /> <?php echo $geo->name; ?> </div>
             <?php
           }
         }
    }        

}