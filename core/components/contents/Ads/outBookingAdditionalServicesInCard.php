public function outBookingAdditionalServicesInCard($data=[]){
    global $app;

    if($data->order->additional_services){

        foreach (_json_decode($data->order->additional_services) as $key => $value) {

            ?>
            <div class="order-card-additional-services-item" >
              
              <?php echo $data->item->booking->additional_services[$key]["name"]; ?>, <?php echo $app->system->amount($data->item->booking->additional_services[$key]["price"]); ?>

            </div>
            <?php

        }

    }

}