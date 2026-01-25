public function outShippingPointsList(){
    global $app;
    
    $points = $app->model->users_shipping_points->getAll("user_id=?", [$app->user->data->id]);

    if($points){
        foreach ($points as $key => $value) {
           $delivery = $app->model->system_delivery_services->find("id=?", [$value["delivery_id"]]);
           if($delivery){
               ?>
               <div>
                   <img src="<?php echo $app->addons->delivery($delivery->alias)->logo(); ?>" height="30px" >
                   <div><?php echo $value["address"]; ?></div>
               </div>
               <?php
           }
        }
    }

}