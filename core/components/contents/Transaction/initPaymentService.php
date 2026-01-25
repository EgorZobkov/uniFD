public function initPaymentService($aliasOrId=null,$params=[]){
    global $app;

    $action = $this->getActionCode($params["target"]);

    $getPayment = $app->model->system_payment_services->find("(alias=? or id=?) and status=?", [$aliasOrId, $aliasOrId, 1]);
    if($getPayment){

        $app->model->transactions_operations->insert(["order_id"=>$params["order_id"],"user_id"=>$params["user_id"],"time_create"=>$app->datetime->getDate(), "data"=>encrypt(_json_encode($params)), "status_processing"=>"awaiting_payment", "currency_code"=>$app->settings->system_default_currency, "amount"=>$params["amount"]]);

        $payment = $app->addons->payment($getPayment->alias)->createPayment(["amount"=>$params["amount"], "order_id"=>$params["order_id"], "title"=>translate("tr_157298fd7045a53d1be4ea9dfe3d91dc")." №".$params["order_id"], "user_name"=>$params["user_name"], "user_phone"=>$params["user_phone"], "user_email"=>$params["user_email"]]);

        if($payment["link"]){
            return ["status"=>true, "link"=>$payment["link"], "order_id"=>$params["order_id"]];
        }else{
            return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
        }

    }else{
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

}