public function addPaymentScoreUser($order_id=0, $user_id=0, $score=null){   
    global $app;

    $result = $app->component->profile->addPaymentScore($user_id, $score);

    if($result["status"] == true){
        $app->model->transactions_deals_payments->update(["status_processing"=>"awaiting_payment"], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
    }
    return $result;
}