<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Delivery
{

 public $alias = "delivery";

 public function calculationData($point_id=0, $item_id=0, $user_id=0){
    global $app;

    $data = (object)[];

    $ad = $app->component->ads->getAd((int)$item_id);

    if($ad && !$ad->delete){

        $delivery_point = $app->model->delivery_points->find("id=?", [(int)$point_id]);

        if($delivery_point){

            $delivery = $app->model->system_delivery_services->find("id=?", [$delivery_point->delivery_id]);

            if($delivery){

                $data->delivery_point = $delivery_point;

                $user_shipping = $app->model->users_shipping_points->find("delivery_id=? and user_id=?", [$delivery_point->delivery_id, $ad->user->id]);

                if($user_shipping){

                    $data->user_shipping_point = $app->model->delivery_points->find("id=?", [$user_shipping->point_id]);

                    if($data){

                        $params = (object)["data"=>$data, "ad"=>$ad];

                        return $app->addons->delivery($delivery->alias)->calculation($params);

                    }

                }

            }

        }

    }

    return [];

}

public function cancelOrder($delivery_id=0, $data=[]){
    global $app;

    $delivery = $app->model->system_delivery_services->find("id=?", [$delivery_id]);

    if($delivery){
        return $app->addons->delivery($delivery->alias)->cancelOrder(["id"=>$data["id"]]);
    }

    return [];

}

public function createOrder($data=[]){
    global $app;

    $ad = $app->component->ads->getAd($data->item->item_id);

    if($ad){

        if($data->delivery_service){
            $params = (object)["data"=>$data, "ad"=>$ad];
            return $app->addons->delivery($data->delivery_service->alias)->createOrder($params);
        }

    }

    return [];

}

public function hasAvailableDelivery($ad=[], $data=[]){
    global $app;

    $data = (object)$data;

    $user_shipping = $app->model->users_shipping_points->find("delivery_id=? and user_id=?", [$data->id, $ad->user->id]);

    if($ad->delivery_status == 1 && $ad->user->delivery_status && $user_shipping){

        if($ad->price >= $data->available_price_min && ($ad->price <= $data->available_price_max || !$data->available_price_max) && $ad->category->delivery_size_weight >= $data->min_weight && ($ad->category->delivery_size_weight <= $data->max_weight || !$data->max_weight)){
            return true;
        }

    }

    return false;

}

public function outDeliveryListInCart($id=0){
    global $app;

    $ad = $app->component->ads->getAd($id);

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

            <div class="order-buy-card-delivery-item actionCartChangeDelivery actionOpenStaticModal" data-id="<?php echo $value["id"]; ?>" data-item-id="<?php echo $id; ?>" data-modal-target="deliveryPoints" data-modal-params="<?php echo buildAttributeParams(["id"=>$value["id"], "item_id"=>$ad->id]); ?>" >
                <span> <img src="<?php echo $app->addons->delivery($value["alias"])->logo(); ?>" > </span>
                <span> <strong><?php echo $value["name"]; ?></strong> </span>
            </div>

            <?php
            }
        }
    }

}

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

public function outDeliveryListInProfile(){
    global $app;

    if($app->settings->integration_delivery_services_active){
        $data = $app->model->system_delivery_services->getAll("status=? and id IN(".implode(",", $app->settings->integration_delivery_services_active).")", [1]);
    }

    if($data){
        foreach ($data as $key => $value) {
            ?>

            <div class="order-buy-card-delivery-item actionBuyChangeDelivery actionOpenStaticModal" data-id="<?php echo $value["id"]; ?>" data-modal-target="deliveryPoints" data-modal-params="<?php echo buildAttributeParams(["id"=>$value["id"], "send"=>1]); ?>" >
                <span> <img src="<?php echo $app->addons->delivery($value["alias"])->logo(); ?>" > </span>
                <span> <strong><?php echo $value["name"]; ?></strong> </span>
            </div>

            <?php
        }
    }

}

public function outHistoryData($order_id=0, $user_id=0){
    global $app;

    $order = $app->model->transactions_deals->find("order_id=? and (from_user_id=? or whom_user_id=?)", [$order_id,$user_id,$user_id]);
    if($order){
        if($order->delivery_service_id){
            $service = $app->model->system_delivery_services->find("id=?", [$order->delivery_service_id]);
            if($service){
                $order->delivery_history_data = $order->delivery_history_data ? _json_decode(decrypt($order->delivery_history_data)) : [];
                echo $app->addons->delivery($service->alias)->outHistory((array)$order, $user_id);
            }
        }
    }

}

public function searchPoints($point_id=0, $query=null){
    global $app;

    $result = [];

    $delivery = $app->model->system_delivery_services->find("id=?", [(int)$point_id]);

    if($delivery){
        $data = $app->model->delivery_points->sort("address asc limit 100")->search($query)->getAll("delivery_id=?",[$delivery->id]);
    }else{
        $data = $app->model->delivery_points->sort("address asc limit 100")->search($query)->getAll();
    }

    if($data){

        foreach ($data as $value) {

            $result[] = ["id"=>$value["id"], "delivery_id"=>$value["delivery_id"]?:0, "address"=>$value["address"], "latitude"=>$value["latitude"]?:0, "longitude"=>$value["longitude"]?:0, "point_code"=>$value["code"]];

        }

    }

    return $result;

}

public function updateHistoryData($data=[]){
    global $app;

    $result = [];

    $service = $app->model->system_delivery_services->find("id=?", [(int)$data["delivery_service_id"]]);
    if($service){
        $data["delivery_history_data"] = $data["delivery_history_data"] ? _json_decode(decrypt($data["delivery_history_data"])) : [];
        $data["delivery_answer_data"] = $data["delivery_answer_data"] ? _json_decode($data["delivery_answer_data"]) : [];
        $result = $app->addons->delivery($service->alias)->getHistory($data);
        if($result["status"] == true){
            $app->model->transactions_deals->update(["delivery_history_data"=>encrypt(_json_encode($result["data"]))], ["order_id=?", [$data["order_id"]]]);
            if($result["sending_status"] == true){
                $app->model->transactions_deals->update(["status_processing"=>"confirmed_send_shipment"], ["order_id=?", [$data["order_id"]]]);
            }
        }
    }

    return $result;

}



}