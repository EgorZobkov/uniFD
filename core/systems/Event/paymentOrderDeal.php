public function paymentOrderDeal($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["item_id"], "count"=>$data["count"], "action_code"=>"buy"]);
    $app->component->chat->sendAction("system_create_order", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"], "ad_id"=>$data["item_id"]], false);
    $app->notify->params((array)$data)->userId($data["whom_user_id"])->code("payment_order_deal")->addWaiting();

}