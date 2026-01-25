public function services(){

    $ids = [];

    $getOrders = $this->model->ads_services_orders->sort("id asc limit 500")->getAll("now() >= time_expiration");
    
    if($getOrders){

        foreach ($getOrders as $key => $value) {
            $ids[] = $value["id"];
            $this->component->ad_paid_services->deactivation($value["service_id"],$value["ad_id"]);
        }

        $this->model->ads_services_orders->delete("id IN(".implode(",", $ids).")");

    }

}