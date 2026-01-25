public function addHistoryDeal($param=[]){   
    global $app;

    $app->model->transactions_deals_history->insert(["order_id"=>$param['order_id'], "comment"=>$param['comment']?:null, "action_code"=>$param['action_code']?:null, "time_create"=>$app->datetime->getDate(), "user_id"=>$param['user_id']?:0, "media"=>$param['media']?:null]);

}