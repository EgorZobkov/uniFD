public function addSolutionDisputeDeal($order_id=0, $code=null, $text=null){
    global $app;

    $getDeal = $this->getDealItem($order_id);

    if($getDeal){

        $app->component->transaction->addHistoryDeal(["order_id"=>$order_id, "action_code"=>$code, "comment"=>$text]);

        $app->model->transactions_deals->update(["status_processing"=>"completed_order", "status_completed"=>1, "time_update"=>$app->datetime->getDate()], ["order_id=?", [$order_id]]);

        if($getDeal->status_processing != $code){

            if($code == "solution_completed_order"){
                
                $app->model->transactions_deals_payments->insert(["order_id"=>$order_id, "amount"=>$this->calculationDealProfitUserPayments($getDeal->amount, $getDeal->delivery_amount), "time_create"=>$app->datetime->getDate(), "status_processing"=>$app->component->profile->getPaymentData($getDeal->whom_user_id) ? "awaiting_payment" : "no_score", "whom_user_id"=>$getDeal->whom_user_id]);

                $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"completed_order"]);

                if($app->settings->secure_deal_profit_percent){

                    $this->create(["order_id"=>$order_id,"amount"=>$this->calculationDealProfit($getDeal->amount,$getDeal->delivery_amount)+$getDeal->delivery_amount, "data"=>null, "target"=>"secure_deal"]);

                }

            }elseif($code == "solution_refund_full_amount"){

                $app->model->transactions_deals->update(["status_processing"=>"cancel_order", "time_update"=>$app->datetime->getDate()], $getDeal->id);

                $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"cancel_order"]);

                $this->paymentRefund($getDeal);
                
            }elseif($code == "solution_refund_half_amount"){

                $amount = $this->calculationDealProfitUserPayments($getDeal->amount, $getDeal->delivery_amount) / 2;

                $app->model->transactions_deals_payments->insert(["order_id"=>$order_id, "amount"=>$amount, "time_create"=>$app->datetime->getDate(), "status_processing"=>$app->component->profile->getPaymentData($getDeal->from_user_id) ? "awaiting_payment" : "no_score", "whom_user_id"=>$getDeal->from_user_id]);

                $app->model->transactions_deals_payments->insert(["order_id"=>$order_id, "amount"=>$amount, "time_create"=>$app->datetime->getDate(), "status_processing"=>$app->component->profile->getPaymentData($getDeal->whom_user_id) ? "awaiting_payment" : "no_score", "whom_user_id"=>$getDeal->whom_user_id]);
                
                $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"completed_order"]);
                
                if($app->settings->secure_deal_profit_percent){

                    $this->create(["order_id"=>$order_id,"amount"=>$this->calculationDealProfit($getDeal->amount,$getDeal->delivery_amount)+$getDeal->delivery_amount, "data"=>null, "target"=>"secure_deal"]);

                }

            }

            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->from_user_id)->code("change_status_order_deal")->addWaiting();
            $app->notify->params(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id])->userId($getDeal->whom_user_id)->code("change_status_order_deal")->addWaiting();

        }

    }

}