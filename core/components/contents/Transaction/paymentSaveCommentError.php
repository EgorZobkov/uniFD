public function paymentSaveCommentError($id=0, $comment=null, $notify_recipient=0){   
    global $app;

    $getPayment = $app->model->transactions_deals_payments->find("id=?", [$id]);

    if($getPayment){

        $app->model->transactions_deals_payments->update(["status_processing"=>"payment_error", "comment"=>$comment, "user_show_error"=>$notify_recipient ? 1 : 0], $id);

        if($notify_recipient){
            $app->notify->params(["order_id"=>$getPayment->order_id, "text"=>$comment, "link"=>getHost(true).'/order/card/'.$getPayment->order_id])->userId($getPayment->whom_user_id)->code("deal_error")->addWaiting();
        }   

    }

}