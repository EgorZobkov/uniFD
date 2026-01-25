public function createPayout($data=[], $alias=null){
    global $app;

    $user = $app->model->users->find("id=?", [$data["whom_user_id"]]);

    $payment_data = $app->model->users_payment_data->find("user_id=? and default_status=?", [$data["whom_user_id"], 1]);

    if(!$payment_data){
        $app->model->transactions_deals_payments->update(["comment"=>translate("tr_9779beaec0dc376e8e4f63bb9098d458"), "user_show_error"=>0], $data["id"]);
        return;
    }

    if(!$payment_data->score){
        $app->model->transactions_deals_payments->update(["comment"=>translate("tr_5557733260d5065a26cfef9addeba834"), "user_show_error"=>1], $data["id"]);
        return;
    }

    $payment_data->score = decrypt($payment_data->score);

    if($alias){
        $app->addons->payment($alias)->createPayout(["id"=>$data["id"], "amount"=>$data["amount"], "order_id"=>$data["order_id"], "payment_data"=>(array)$payment_data, "user_data"=>(array)$user, "title"=>translate("tr_475022c979c1e73a56d2d632181b6237").' '.$data["order_id"]]);
    }

}