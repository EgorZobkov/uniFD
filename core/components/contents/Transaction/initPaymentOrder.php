public function initPaymentOrder($id=0, $user_id=0){
    global $app;

    $transaction = $app->model->transactions_deals->find("order_id=?", [$id]);

    if(!$transaction){
        return ["status"=>false, "answer"=>translate("tr_39747e975806eaa650385b84f760cb92")];
    }

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    $transaction->item = $app->model->transactions_deals_items->find("order_id=?", [$id]);

    $params["target"] = "secure_deal";
    $params["order_id"] = $transaction->order_id;
    $params["items"][] = ["id"=>$transaction->item->item_id, "count"=>$transaction->item->count, "price"=>$transaction->item->price, "amount"=>round($transaction->item->amount,2), "user_id"=>$transaction->item->user_id];
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["amount"] = round($transaction->amount,2);
    $params["payment_id"] = $app->settings->integration_payment_service_secure_deal_active;
    $params["return_url"] = getHost(true) . '/profile/orders';

    return $this->initPaymentService($params["payment_id"], $params);

}