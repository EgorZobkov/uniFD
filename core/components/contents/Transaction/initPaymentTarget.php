public function initPaymentTarget($payment_id=null,$params=[], $user_id=0){
    global $app;

    if($this->checkCorrectData($params) == false){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    if($params["service_id"]){
        $params["service_data"] = $app->component->ad_paid_services->getServiceData($params["service_id"], $params["count_day"][$params["service_id"]]);
        $order = $app->component->ad_paid_services->getActiveOrder($params["id"], $params["service_id"]);
        if($order){
            return ["status"=>false, "answer"=>translate("tr_3db019a3d6f99b7502794256a806abdb")];
        }
    }elseif($params["tariff_id"]){
        $params["tariff_data"] = $app->component->service_tariffs->getTariffData($params["tariff_id"]);
        $result = $app->component->service_tariffs->checkAddTariff($params["tariff_id"], $user->id);
        if($result){
            return $result;
        }
    }elseif($params["id"]){
        $ad = $app->model->ads_data->find("id=?", [$params["id"]]);
        $params["category_name"] = $app->component->ads_categories->categories[$ad->category_id]["name"];
    }

    $params["order_id"] = generateOrderId();
    $params["amount"] = $this->getPaymentTargetAmount($params);
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["return_url"] = getHost(true);
    $params["payment_id"] = $payment_id;

    if(!$params["amount"]){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    if(!$payment_id){
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

    if($payment_id == "balance" && $app->settings->profile_wallet_status){

        if($user->balance >= $params["amount"]){

            $this->manageUserBalance(["user_id"=>$user->id, "amount"=>$params["amount"]], "-");
            $this->callback($params);

            $app->session->setNotify("success", translate("tr_8ad1afff1d010bb86b13d3c9b7c6cb9d"));

            return ["status"=>true, "update"=>true];
        }else{
            return ["status"=>false, "answer"=>translate("tr_9549a9bae4363d8b5a02d13433be2245")];
        }

    }else{

        return $this->initPaymentService($payment_id,$params);

    }

}