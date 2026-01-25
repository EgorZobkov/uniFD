public function createDeal($params=[]){
    global $app;

    $order_id = generateOrderId();

    if($params["delivery_amount"]){
        $amount = $params["amount"] + $params["delivery_amount"];
    }else{
        $amount = $params["amount"];
    }

    $app->model->transactions_deals->insert(["order_id"=>$order_id, "operation_id"=>$params["operation_id"]?:0, "amount"=>$amount, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "from_user_id"=>(int)$params["from_user_id"], "whom_user_id"=>(int)$params["whom_user_id"], "status_payment"=>(int)$params["status_payment"], "status_processing"=>$params["status_processing"]?:null, "time_completed"=>$params["time_completed"]?:null, "delivery_service_id"=>$params["delivery"] ? (int)$params["delivery"]["delivery_id"] : 0, "delivery_data"=>$params["delivery"] ? encrypt(_json_encode($params["delivery"])) : null, "delivery_amount"=>$params["delivery_amount"]?:0]);

    $app->model->transactions_deals_items->insert(["order_id"=>$order_id, "item_id"=>(int)$params["item_id"], "count"=>(int)$params["count"], "amount"=>$params["amount"], "price"=>$params["price"], "user_id"=>(int)$params["whom_user_id"], "from_user_id"=>(int)$params["from_user_id"], "external_content"=>$params["external_content"]?:null]);

    return $order_id;      

}