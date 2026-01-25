public function changeStatusDeal($order_id=0,$user_id=0, $status=null){
    global $app;

    $delivery_answer_data = [];

    $getDeal = $this->getDealItem($order_id);

    if($getDeal->status_processing != $status){

        if($status == "confirmed_order"){

            if($getDeal->delivery_service_id){
                $delivery_answer_data = $app->component->delivery->createOrder($getDeal);
                if($delivery_answer_data["status"]){
                    $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate(), "delivery_answer_data"=>$delivery_answer_data ? _json_encode($delivery_answer_data) : null], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
                    $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"confirmed_order"]);
                    $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("confirmed_order_deal")->addWaiting();                    
                }else{
                    return ["status"=>false, "answer"=>$delivery_answer_data["answer"]];
                }
            }else{
                $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate(), "delivery_answer_data"=>null], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
                $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"confirmed_order"]);
                $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("confirmed_order_deal")->addWaiting();
            }

        }elseif($status == "confirmed_send_shipment"){

            $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate()], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
            $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"confirmed_send_shipment"]);
            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("change_status_order_deal")->addWaiting();

        }elseif($status == "confirmed_transfer"){

            $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate()], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
            $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"confirmed_transfer"]);
            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("change_status_order_deal")->addWaiting();

        }elseif($status == "confirmed_completion_service"){

            $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate()], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
            $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"confirmed_completion_service"]);
            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("change_status_order_deal")->addWaiting();

        }elseif($status == "completed_order"){

            if($getDeal->from_user_id == $user_id){

                if(!$app->model->transactions_deals_payments->find("order_id=? and whom_user_id=?", [$order_id, $getDeal->whom_user_id])){

                    $app->model->transactions_deals->update(["status_processing"=>$status, "status_completed"=>1, "time_update"=>$app->datetime->getDate()], ["order_id=?", [$order_id]]);

                    $app->model->transactions_deals_payments->insert(["order_id"=>$order_id, "amount"=>$this->calculationDealProfitUserPayments($getDeal->amount, $getDeal->delivery_amount), "time_create"=>$app->datetime->getDate(), "status_processing"=>$app->component->profile->getPaymentData($getDeal->whom_user_id) ? "awaiting_payment" : "no_score", "whom_user_id"=>$getDeal->whom_user_id]);

                    $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"completed_order"]);

                    if($app->settings->secure_deal_profit_percent){

                        $this->create(["order_id"=>$order_id,"amount"=>$this->calculationDealProfit($getDeal->amount, $getDeal->delivery_amount)+$getDeal->delivery_amount, "data"=>null, "target"=>"secure_deal"]);

                    }

                    $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->whom_user_id)->code("change_status_order_deal")->addWaiting();

                }

            }
            
        }elseif($status == "open_dispute"){

            $app->model->transactions_deals->update(["status_processing"=>$status, "time_update"=>$app->datetime->getDate()], ["order_id=?", [$order_id]]);
            
            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->whom_user_id)->code("open_dispute_order_deal")->addWaiting();

            $app->event->openDisputeDeal(["order_id"=>$order_id]);

        }

        return ["status"=>true];

    }

    return ["status"=>false];

}