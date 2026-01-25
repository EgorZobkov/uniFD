public function cancelDeal($order_id=0, $user_id=0, $reason=null){   
    global $app;

    $getDeal = $this->getDealItem($order_id);

    if($getDeal){

        if($getDeal->from_user_id == $user_id || $getDeal->whom_user_id == $user_id){

            if($getDeal->status_processing == "awaiting_confirmation" || $getDeal->status_processing == "confirmed_order" || $getDeal->status_processing == "booked"){ 

                $app->model->transactions_deals->update(["status_processing"=>"cancel_order", "time_update"=>$app->datetime->getDate()], $getDeal->id);

                $app->model->booking_dates->delete("order_id=?", [$order_id]);

                if($getDeal->from_user_id == $user_id){
                    $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"cancel_order_from_user", "comment"=>$reason]);
                    $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->whom_user_id)->code("cancel_order_deal")->addWaiting();
                }else{
                    $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"cancel_order_whom_user", "comment"=>$reason]);
                    $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("cancel_order_deal")->addWaiting();
                }

                if($getDeal->status_payment){
                    $this->paymentRefund($getDeal);
                }

                if($getDeal->delivery_service_id){
                    $app->component->delivery->cancelOrder($getDeal->delivery_service_id, $getDeal->delivery_answer_data);
                }

            }

        }

    }

}