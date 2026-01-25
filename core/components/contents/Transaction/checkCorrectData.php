public function checkCorrectData($params=[]){
    global $app;

    if($params["target"]){
        if(!$this->getActionCode($params["target"])){
            return false;
        }
    }else{
        return false;
    }

    if($params["target"] == "paid_ad_services"){

        if($params["id"]){
            $ad = $app->model->ads_data->find("id=?", [$params["id"]]);
            if(!$ad){
                return false;
            }
        }else{
            return false;
        }

        if($params["service_id"]){
            $getService = $app->model->ads_services->find("id=? and status=?", [$params["service_id"],1]);
            if(!$getService){
                return false;
            }
        }else{
            return false;
        }

    }elseif($params["target"] == "service_tariff"){
        if($params["tariff_id"]){
            $getService = $app->model->users_tariffs->find("id=? and status=?", [$params["tariff_id"],1]);
            if(!$getService){
                return false;
            }
        }else{
            return false;
        }
    }

    return true;

}