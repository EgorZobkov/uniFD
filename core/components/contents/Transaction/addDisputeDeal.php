public function addDisputeDeal($order_id=0, $user_id=0, $text=null, $media=null){   
    global $app;

    $deal = $app->model->transactions_deals->find("order_id=? and (from_user_id=? or whom_user_id=?) and status_processing!=?", [$order_id,$user_id,$user_id,"completed_order"]);

    if($deal){
        $app->component->transaction->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"open_dispute", "comment"=>$text, "user_id"=>$user_id, "media"=>$media ? _json_encode($media) : null]);
        $this->changeStatusDeal($order_id, $user_id, "open_dispute");
    }

}