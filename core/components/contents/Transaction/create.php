public function create($params=[]){
    global $app;

    if(!$app->model->transactions->find("order_id=? and action_code=? and status_payment=?", [$params["order_id"],$params["target"],1])){

        $app->model->transactions->insert(["order_id"=>$params["order_id"],"user_id"=>(int)$params["user_id"],"amount"=>$params["amount"], "item_id"=>(int)$params["item_id"], "data"=>encrypt(_json_encode($params)), "status_payment"=>1, "status_processing"=>1, "action_code"=>$params["target"], "time_create"=>$app->datetime->getDate(),"currency_code"=>$app->settings->system_default_currency, "service_id"=>(int)$params["service_id"], "tariff_id"=>(int)$params["tariff_id"]]);

        $app->event->createTransaction($params);

        return true;

    }

    return false;

}