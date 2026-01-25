public function getPaymentTargetAmount($params=[]){
    global $app;

    $amount = 0;

    if($params["target"] == "paid_category"){

        if($params["id"]){
            $getAd = $app->model->ads_data->find("id=?", [$params["id"]]);
            if($getAd){
                $amount = $app->component->ads_categories->categories[$getAd->category_id]["paid_cost"];
            }
            return $amount;
        }

    }elseif($params["target"] == "paid_ad_services"){
        
        $service_data = $app->component->ad_paid_services->getServiceData($params["service_id"], $params["count_day"][$params["service_id"]]);
        if($service_data){
            $amount = $service_data["amount"];
        }

    }elseif($params["target"] == "service_tariff"){
        
        $service_data = $app->model->users_tariffs->find("id=? and status=?", [$params["tariff_id"], 1]);

        if($service_data){
            $amount = $service_data->price;
        }

    }        

    return $amount;

}