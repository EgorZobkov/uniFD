public function initPaymentWallet($params=[], $user_id=0){
    global $app;

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    $params["target"] = "user_balance";
    $params["order_id"] = generateOrderId();
    $params["amount"] = $params["amount"] ? round($params["amount"],2) : 0;
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["return_url"] = getHost(true) . '/profile/wallet';
    
    if(!$params["amount"]){
        return ["status"=>false, "answer"=>translate("tr_5842afafbfb783fefe64321d693b5af5")];
    }else{
        if($params["amount"] < $app->settings->profile_wallet_min_amount_replenishment || $params["amount"] > $app->settings->profile_wallet_max_amount_replenishment){
            return ["status"=>false, "answer"=>translate("tr_a068b723145e72dc2b3ea63b39bae5df")." ".$app->system->amount($app->settings->profile_wallet_min_amount_replenishment)." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$app->system->amount($app->settings->profile_wallet_max_amount_replenishment)];
        }
    }

    if(!$params["payment_id"]){
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

    return $this->initPaymentService($params["payment_id"], $params);

}