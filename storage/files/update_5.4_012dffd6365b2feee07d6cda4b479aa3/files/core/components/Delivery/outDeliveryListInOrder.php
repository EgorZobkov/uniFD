public function outDeliveryListInOrder($ad=[]){
    global $app;

    if($ad->delivery_status != 1){
        return "";
    }

    if($app->settings->integration_delivery_services_active){
        $data = $app->model->system_delivery_services->getAll("status=? and id IN(".implode(",", $app->settings->integration_delivery_services_active).")", [1]);
    }

    if($data){
        foreach ($data as $key => $value) {
            if($this->hasAvailableDelivery($ad, $value)){
            ?>

            <div class="order-buy-card-delivery-item actionBuyChangeDelivery actionOpenStaticModal" data-id="<?php echo $value["id"]; ?>" data-modal-target="deliveryPoints" data-modal-params="<?php echo buildAttributeParams(["id"=>$value["id"], "item_id"=>$ad->id]); ?>" >
                <span> <img src="<?php echo $app->addons->delivery($value["alias"])->logo(); ?>" > </span>
                <span> <strong><?php echo $value["name"]; ?></strong> </span>
            </div>

            <?php
            }
        }
    }

}