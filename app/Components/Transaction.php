<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Transaction
{

 public $alias = "transaction";

 public function actionsCode(){   
    global $app;

    $result["user_balance"] = ["code"=>"user_balance", "name"=>translate("tr_4794c3c39a4578aa6096bf3ced5d5a89"), "template"=>translate("tr_4794c3c39a4578aa6096bf3ced5d5a89")];
    $result["paid_ad_services"] = ["code"=>"paid_ad_services", "name"=>translate("tr_69e15c68de676d2fd96c2f1be07206ca"), "template"=>translate("tr_69e15c68de676d2fd96c2f1be07206ca")." - {service_name} ".translate("tr_1f6c150ae7fba44b3897f51c51c4ca47")." {service_count_day}"];
    $result["service_tariff"] = ["code"=>"service_tariff", "name"=>translate("tr_77ce3f2a493b6c2d4d60d7150e66a819"), "template"=>translate("tr_77ce3f2a493b6c2d4d60d7150e66a819")." - {tariff_name} ".translate("tr_1f6c150ae7fba44b3897f51c51c4ca47")." {tariff_count_day}"];
    $result["paid_category"] = ["code"=>"paid_category", "name"=>translate("tr_c555584a25bfff6c85b1f3e3835f4ff7"), "template"=>translate("tr_4f28d671f86a6da6ca38d7609036510f")." - {category_name}"];
    $result["user_stories"] = ["code"=>"user_stories", "name"=>translate("tr_ba1fb533d4411243e29c80dfccb00686"), "template"=>translate("tr_ba1fb533d4411243e29c80dfccb00686")];
    $result["secure_deal"] = ["code"=>"secure_deal", "name"=>translate("tr_c21b2ddff1f121219f81a576c5f6a242"), "template"=>translate("tr_c21b2ddff1f121219f81a576c5f6a242")];

    return $result;

}

public function addDisputeDeal($order_id=0, $user_id=0, $text=null, $media=null){   
    global $app;

    $deal = $app->model->transactions_deals->find("order_id=? and (from_user_id=? or whom_user_id=?) and status_processing!=?", [$order_id,$user_id,$user_id,"completed_order"]);

    if($deal){
        $app->component->transaction->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"open_dispute", "comment"=>$text, "user_id"=>$user_id, "media"=>$media ? _json_encode($media) : null]);
        $this->changeStatusDeal($order_id, $user_id, "open_dispute");
    }

}

public function addHistoryDeal($param=[]){   
    global $app;

    $app->model->transactions_deals_history->insert(["order_id"=>$param['order_id'], "comment"=>$param['comment']?:null, "action_code"=>$param['action_code']?:null, "time_create"=>$app->datetime->getDate(), "user_id"=>$param['user_id']?:0, "media"=>$param['media']?:null]);

}

public function addPaymentScoreUser($order_id=0, $user_id=0, $score=null){   
    global $app;

    $result = $app->component->profile->addPaymentScore($user_id, $score);

    if($result["status"] == true){
        $app->model->transactions_deals_payments->update(["status_processing"=>"awaiting_payment"], ["order_id=? and whom_user_id=?", [$order_id, $user_id]]);
    }
    return $result;
}

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

public function buildPaymentButton($params=[]){
    global $app;

    $amount = $this->getPaymentTargetAmount($params);

    if($params["button_name"]){
        $button_name = $params["button_name"];
    }else{
        $button_name = translate("tr_4caffb2a58fc0bd6f790d3e85b054125").' '.$app->system->amount($amount);
    }

    return '<button class="initOptionsPayment '.$params["class"].'" data-params="'.urlencode(_json_encode($params)).'" >'.$button_name.'</button>';

}

public function calculationDealProfit($amount=0, $delivery_amount=0){
    global $app;

    return calculatePercent($amount-$delivery_amount, $app->settings->secure_deal_profit_percent);

}

public function calculationDealProfitUserPayments($amount=0, $delivery_amount=0){
    global $app;

    if($delivery_amount){
        $amount = $amount-$delivery_amount;
    }

    return $amount - calculatePercent($amount, $app->settings->secure_deal_profit_percent);
}

public function callback($params=[], $callback_data=null){
    global $app;

    if($app->model->transactions_operations->find("order_id=? and status_processing=?", [$params["order_id"], "paid"])){
        return;
    }

    $app->model->transactions_operations->update(["status_processing"=>"paid","callback_data"=>$callback_data ? encrypt($callback_data) : null], ["order_id=?", [$params["order_id"]]]);

    if($params["target"] == "user_balance"){

        if($this->create($params)){

            $this->manageUserBalance(["user_id"=>$params["user_id"], "amount"=>$params["amount"]], "+");

            $app->component->profile->fixAwardReferral($params["user_id"], $params["amount"]);

        }

    }elseif($params["target"] == "paid_category"){

        if($this->create($params)){

            $ad = $app->model->ads_data->find("id=?", [$params["id"]]);

            if($ad){

                $app->model->ads_paid_publications->insert(["user_id"=>$params["user_id"], "category_id"=>$ad->category_id, "ad_id"=>$params["id"]]);

                $app->model->ads_data->cacheKey(["id"=>$params["id"]])->update(["status"=>1], $params["id"]);

                if(!$ad->time_update){
                    $app->component->ads_counter->updateCount($ad->category_id, $ad->city_id, $ad->region_id, $ad->country_id, 1);
                }

                $app->component->profile->fixAwardReferral($params["user_id"], $params["amount"]);
                
            }

        }

    }elseif($params["target"] == "paid_ad_services"){

        if($this->create($params)){

            $app->component->ad_paid_services->createOrder(["order_id"=>$params["order_id"], "user_id"=>$params["user_id"], "ad_id"=>$params["id"], "service_id"=>$params["service_id"], "count_day"=>$params["service_data"]["count"]]);

            $app->component->profile->fixAwardReferral($params["user_id"], $params["amount"]);

        }

    }elseif($params["target"] == "service_tariff"){

        if($this->create($params)){

            $app->component->service_tariffs->createOrder(["order_id"=>$params["order_id"], "user_id"=>$params["user_id"], "tariff_id"=>$params["tariff_id"], "amount"=>$params["amount"]]);

            $app->component->profile->fixAwardReferral($params["user_id"], $params["amount"]);

        }

    }elseif($params["target"] == "secure_deal"){

        if($params["items"]){
            foreach ($params["items"] as $value) {

                $deal = $app->model->transactions_deals->find("order_id=?", [$params["order_id"]]);

                if(!$deal){

                    $ad = $app->model->ads_data->find("id=?", [$value["id"]]);

                    if($app->component->ads_categories->categories[$ad->category_id]["type_goods"] == "electronic_goods"){
                        $status_processing = "access_open";
                    }else{
                        $status_processing = "awaiting_confirmation";
                    }

                    $order_id = $this->createDeal(["operation_id"=>$params["order_id"], "amount"=>$value["amount"], "from_user_id"=>$params["user_id"], "whom_user_id"=>$value["user_id"], "status_payment"=>1, "status_processing"=>$status_processing, "item_id"=>$value["id"], "count"=>$value["count"], "price"=>$value["price"], "external_content"=>$ad->external_content?:null, "delivery"=>$value["delivery"], "delivery_amount"=>$params["delivery_amount"]]);

                    $this->addHistoryDeal(["order_id"=>$order_id, "action_code"=>"payment"]);

                    $this->warehouseItem($value["id"],$value["count"],"-");

                    $this->deleteItemCart($value["cart_item_id"]);

                    $app->event->paymentOrderDeal(["order_id"=>$order_id, "link"=>getHost(true).'/order/card/'.$order_id, "amount"=>$value["amount"], "from_user_id"=>$params["user_id"], "whom_user_id"=>$value["user_id"], "item_id"=>$value["id"], "count"=>$value["count"]]);

                }else{

                    $app->model->transactions_deals->update(["time_update"=>$app->datetime->getDate(), "status_payment"=>1, "operation_id"=>$params["operation_id"], "status_processing"=>"booked"], $deal->id);

                    $this->addHistoryDeal(["order_id"=>$deal->order_id, "action_code"=>"payment"]);

                    $app->event->paymentOrderDeal(["order_id"=>$deal->order_id, "link"=>getHost(true).'/order/card/'.$deal->order_id, "amount"=>$value["amount"], "from_user_id"=>$params["user_id"], "whom_user_id"=>$value["user_id"], "item_id"=>$value["id"]]);

                }

            }
        }

    }        

}

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

public function checkCorrectData($params=[]){
    global $app;

    if($params["target"]){
        if(!$this->getActionCode($params["target"])){
            return false;
        }
    }else{
        return false;
    }

    if($params["target"] == "paid_ad_services"){

        if($params["id"]){
            $ad = $app->model->ads_data->find("id=?", [$params["id"]]);
            if(!$ad){
                return false;
            }
        }else{
            return false;
        }

        if($params["service_id"]){
            $getService = $app->model->ads_services->find("id=? and status=?", [$params["service_id"],1]);
            if(!$getService){
                return false;
            }
        }else{
            return false;
        }

    }elseif($params["target"] == "service_tariff"){
        if($params["tariff_id"]){
            $getService = $app->model->users_tariffs->find("id=? and status=?", [$params["tariff_id"],1]);
            if(!$getService){
                return false;
            }
        }else{
            return false;
        }
    }

    return true;

}

public function codeHistoryDeal(){   
    global $app;

    $result["payment"] = ["code"=>"payment", "name"=>translate("tr_d8477c7d886edaad27dabfd2cd3fb86a")];
    $result["confirmed_order"] = ["code"=>"confirmed_order", "name"=>translate("tr_361a6154ef972d6614ecc80b9acf7d2e")];
    $result["cancel_order_from_user"] = ["code"=>"cancel_order_from_user", "name"=>translate("tr_4f5e47affa437d88fbda75e49f10d9d2")];
    $result["cancel_order_whom_user"] = ["code"=>"cancel_order_whom_user", "name"=>translate("tr_0fef0dc1d1c699888353cb735f032466")];
    $result["cancel_order"] = ["code"=>"cancel_order", "name"=>translate("tr_c302fdafed8f284641ebf94309d38559")];
    $result["open_dispute"] = ["code"=>"open_dispute", "name"=>translate("tr_de30b76ad5df62bc3a7cf4e40fb4a602")];
    $result["confirmed_send_shipment"] = ["code"=>"confirmed_send_shipment", "name"=>translate("tr_e245d6ddf9eb6c8222c2ec39471ee4e1")];
    $result["confirmed_transfer"] = ["code"=>"confirmed_transfer", "name"=>translate("tr_cd8a10a7e7834f3110c614f463c297c5"), "label"=>"success"];
    $result["confirmed_completion_service"] = ["code"=>"confirmed_completion_service", "name"=>translate("tr_1db8895111a4f059392893d800a3c8f1")];
    $result["completed_order"] = ["code"=>"completed_order", "name"=>translate("tr_245743d5301f067be6cb6ae479a9da7f")];
    $result["solution_completed_order"] = ["code"=>"solution_completed_order", "name"=>translate("tr_fc8631e2143b3198e1ce686dfb69340d")];
    $result["solution_refund_full_amount"] = ["code"=>"solution_refund_full_amount", "name"=>translate("tr_70d50f48573627d943729a36c18acb75")];
    $result["solution_refund_half_amount"] = ["code"=>"solution_refund_half_amount", "name"=>translate("tr_5ec670c087456384d53cda71cc208088")];
    $result["access_open"] = ["code"=>"access_open", "name"=>translate("tr_a098d0f2c621675ccaf935f7b43fc917")];
    $result["create_booking"] = ["code"=>"create_booking", "name"=>translate("tr_a5e888318623883ca17d89ac0a253cb6")];

    return $result;

}

public function codeSolutionsDisputeDeal(){   
    global $app;

    $result["solution_completed_order"] = ["code"=>"solution_completed_order", "name"=>translate("tr_cbcae031aaf24f2be3b3cd22d4d0fb9b")];
    $result["solution_refund_full_amount"] = ["code"=>"solution_refund_full_amount", "name"=>translate("tr_70d50f48573627d943729a36c18acb75")];
    $result["solution_refund_half_amount"] = ["code"=>"solution_refund_half_amount", "name"=>translate("tr_5ec670c087456384d53cda71cc208088")];

    return $result;

}

public function create($params=[]){
    global $app;

    if(!$app->model->transactions->find("order_id=? and action_code=? and status_payment=?", [$params["order_id"],$params["target"],1])){

        $app->model->transactions->insert(["order_id"=>$params["order_id"],"user_id"=>(int)$params["user_id"],"amount"=>$params["amount"], "item_id"=>(int)$params["item_id"], "data"=>encrypt(_json_encode($params)), "status_payment"=>1, "status_processing"=>1, "action_code"=>$params["target"], "time_create"=>$app->datetime->getDate(),"currency_code"=>$app->settings->system_default_currency, "service_id"=>(int)$params["service_id"], "tariff_id"=>(int)$params["tariff_id"]]);

        $app->event->createTransaction($params);

        return true;

    }

    return false;

}

public function createDeal($params=[]){
    global $app;

    $order_id = generateOrderId();

    if($params["delivery_amount"]){
        $amount = $params["amount"] + $params["delivery_amount"];
    }else{
        $amount = $params["amount"];
    }

    $app->model->transactions_deals->insert(["order_id"=>$order_id, "operation_id"=>$params["operation_id"]?:0, "amount"=>$amount, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "from_user_id"=>(int)$params["from_user_id"], "whom_user_id"=>(int)$params["whom_user_id"], "status_payment"=>(int)$params["status_payment"], "status_processing"=>$params["status_processing"]?:null, "time_completed"=>$params["time_completed"]?:null, "delivery_service_id"=>$params["delivery"] ? (int)$params["delivery"]["delivery_id"] : 0, "delivery_data"=>$params["delivery"] ? encrypt(_json_encode($params["delivery"])) : null, "delivery_amount"=>$params["delivery_amount"]?:0]);

    $app->model->transactions_deals_items->insert(["order_id"=>$order_id, "item_id"=>(int)$params["item_id"], "count"=>(int)$params["count"], "amount"=>$params["amount"], "price"=>$params["price"], "user_id"=>(int)$params["whom_user_id"], "from_user_id"=>(int)$params["from_user_id"], "external_content"=>$params["external_content"]?:null]);

    return $order_id;      

}

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

public function deleteDeal($order_id=0){   
    global $app;

    $app->model->transactions_deals->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_items->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_payments->delete("order_id=?", [$order_id]);
    $app->model->transactions_deals_history->delete("order_id=?", [$order_id]);

}

public function deleteItemCart($id=0){
    global $app;

    if($id){
        $app->model->cart->delete("id=?", [$id]);
    }

}

public function deleteTransactionMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $app->model->transactions->delete("id=?", [$id]);

        }
    }

}

public function getActionCode($name=null){
    global $app;

    $actionsCode = $this->actionsCode();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}

public function getData($params=[]){   
    global $app;

    $params["user"] = $params["user_id"] ? $app->model->users->findById($params["user_id"]) : [];

    if($params["item_id"]){
        $data = $app->component->ads->getAd($params["item_id"]);
        if($data){
            $params["item_title"] = $data->title;
        }
    }

    return (object)$params;
}

public function getDataDealByValue($value=[]){
    global $app;

    $getItems = $app->model->transactions_deals_items->find("order_id=?", [$value["order_id"]]);

    $value["item"] = $app->component->ads->getAd($getItems->item_id);

    return (object)$value;

}

public function getDataOperationByValue($data=[]){
    global $app;

    $data["user"] = $app->model->users->findById($data["user_id"]);
    $data["data"] = _json_decode($data["data"]);
    $data["service_payment"] = $this->getPaymentService($data["data"]["payment_id"]);

    return (object)$data;

}

public function getDealByItemId($item_id=0, $user_id=0){
    global $app;

    $getItem = $app->model->transactions_deals_items->find("item_id=? and from_user_id=?", [$item_id,$user_id]);

    if($getItem){
        return $app->model->transactions_deals->find("status_completed=? and order_id=?", [0,$getItem->order_id]);
    }

    return [];

}

public function getDealByOrderId($order_id=0){
    global $app;

    $data = $app->model->transactions_deals->find("order_id=?", [$order_id]);

    if($data){

        if($data->delivery_service_id){
            $data->delivery_service = $app->model->system_delivery_services->find("id=?", [$data->delivery_service_id]);
            $data->delivery_data = _json_decode(decrypt($data->delivery_data));
            $data->delivery_point = $app->model->delivery_points->find("code=?", [$data->delivery_data["point_code"]]);
            $data->user_shipping = $app->model->users_shipping_points->find("user_id=? and delivery_id=?", [$data->whom_user_id, $data->delivery_service_id]);
        }

        if($data->delivery_answer_data){
            $data->delivery_answer_data = _json_decode($data->delivery_answer_data);
            $data->user_shipping_point = $app->model->delivery_points->find("code=?", [$data->delivery_answer_data["shipping_point_code"]]);
        }

        $getItem = $app->model->transactions_deals_items->find("order_id=?", [$order_id]);

        $data->item = $app->component->ads->getAd($getItem->item_id);

        if($data->item){

            $data->item->count = $getItem->count;
            $data->item->amount = $getItem->amount;
            $data->item->external_content = $getItem->external_content;

            $data->from_user = $app->model->users->findById($data->from_user_id);
            $data->whom_user = $app->model->users->findById($data->whom_user_id);

            return $data;

        }
        
    }

    return [];

}

public function getDealItem($order_id=0){
    global $app;

    $data = $app->model->transactions_deals->find("order_id=?", [$order_id]);

    if($data){

        $data->item = $app->model->transactions_deals_items->find("order_id=?", [$order_id]);

        if($data->delivery_service_id){
            $data->delivery_service = $app->model->system_delivery_services->find("id=?", [$data->delivery_service_id]);
            $data->delivery_data = _json_decode(decrypt($data->delivery_data));
            $data->delivery_point = $app->model->delivery_points->find("code=?", [$data->delivery_data["point_code"]]);
            $data->user_shipping = $app->model->users_shipping_points->find("user_id=? and delivery_id=?", [$data->whom_user_id, $data->delivery_service_id]);

            if($data->user_shipping){
                $data->user_shipping_point = $app->model->delivery_points->find("code=?", [$data->user_shipping->point_code]);
            }

            if($data->delivery_answer_data){
                $data->delivery_answer_data = _json_decode($data->delivery_answer_data);
            }

        }

        return $data;
    }

    return [];

}

public function getDealsByMonthChart(){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    $y = $app->datetime->format("Y")->getDate();
    $m = $app->datetime->format("m")->getDate();

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        $totalCount = $app->model->transactions_deals->count("date(time_create)=?", [$date]);
        $getAmount = $app->db->getSumByTotal("amount", "uni_transactions_deals", "date(time_create)=?", [$date]);

        $action_count[translate("tr_a2cd08bbbe3c1bea939897a780561a1c")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$totalCount, "title"=>$totalCount.' '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount($getAmount)];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"], "title"=>$value["title"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getHistoryCode($name=null){
    global $app;

    $historyCode = $this->codeHistoryDeal();

    return $historyCode[$name] ? (object)$historyCode[$name] : [];

}

public function getOperation($order_id=null){
    global $app;

    if($order_id){

        $order = $app->model->transactions_operations->find("order_id=?", [$order_id]);

        if($order){
            $order->data = _json_decode(decrypt($order->data));
            $order->callback_data = $order->callback_data ? _json_decode(decrypt($order->callback_data)) : null;
            $order->data["operation_id"] = $order->id;
        }

        return $order;

    }else{
        logger("Error payment not found order id");
        return [];
    }

}

public function getPaymentService($aliasOrId=null){
    global $app;

    if($aliasOrId){
        return $app->model->system_payment_services->find("alias=? or id=?", [$aliasOrId, $aliasOrId]);
    }

    return [];

}

public function getPaymentTargetAmount($params=[]){
    global $app;

    $amount = 0;

    if($params["target"] == "paid_category"){

        if($params["id"]){
            $getAd = $app->model->ads_data->find("id=?", [$params["id"]]);
            if($getAd){
                $amount = $app->component->ads_categories->categories[$getAd->category_id]["paid_cost"];
            }
            return $amount;
        }

    }elseif($params["target"] == "paid_ad_services"){
        
        $service_data = $app->component->ad_paid_services->getServiceData($params["service_id"], $params["count_day"][$params["service_id"]]);
        if($service_data){
            $amount = $service_data["amount"];
        }

    }elseif($params["target"] == "service_tariff"){
        
        $service_data = $app->model->users_tariffs->find("id=? and status=?", [$params["tariff_id"], 1]);

        if($service_data){
            $amount = $service_data->price;
        }

    }        

    return $amount;

}

public function getServiceSecureDeal(){
    global $app;

    if($app->settings->integration_payment_service_secure_deal_active){
        return $app->model->system_payment_services->find("status=? and id=?", [1,$app->settings->integration_payment_service_secure_deal_active]);
    }

    return [];

}

public function getStatisticsByMonthChart($filter_date=null){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_amount = [];

    if($filter_date){
        $y = date("Y", strtotime($filter_date));
        $m = date("m", strtotime($filter_date));  
    }else{
        $y = $app->datetime->format("Y")->getDate();
        $m = $app->datetime->format("m")->getDate();            
    }

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        foreach ($this->actionsCode() as $value) {

            $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=? and action_code=?", [$date,$value["code"]]);

            if($getAmount){
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "amount"=>$getAmount]; 
            }else{
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "amount"=>0];
            }

        }

    }

    foreach ($action_amount as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["amount"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getStatusDeal($code=null){
    global $app;

    $statusCode = $this->statusesDeal();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}

public function getStatusDealPayment($code=null){
    global $app;

    $statusCode = $this->statusesDealPayment();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}

public function getStatusOperation($code=null){
    global $app;

    $statusCode = $this->statusesOperation();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}

public function getTitleByTemplateAction($data=[]){
    global $app;

    $data = (array)$data;
    
    $macrosList = [];
    $template = $this->getActionCode($data["target"])->template;

    if($data["service_data"]){

        $macrosList = [
            "{service_name}"=>$data["service_data"]["name"],
            "{service_count_day}"=>$data["service_data"]["count"] . ' ' . endingWord($data["service_data"]["count"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),
        ];

    }elseif($data["tariff_data"]){

        $count_day = $data["tariff_data"]["count"] ? $data["tariff_data"]["count"] . ' ' . endingWord($data["tariff_data"]["count"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")) : translate("tr_2da14cc34b6c4853a3e022eab0b02e06");

        $macrosList = [
            "{tariff_name}"=>$data["tariff_data"]["name"],
            "{tariff_count_day}"=>$count_day,
        ];

    }elseif($data["category_name"]){

        $macrosList = [
            "{category_name}"=>$data["category_name"],
        ];

    }

    if($macrosList){
        foreach ($macrosList as $key => $value) {
            $template = str_replace($key, $value, $template);
        }
    }

    return $template;
}

public function getTotalDeals(){   
    global $app;

    return $app->model->transactions_deals->count();

}

public function getTotalProfit(){   
    global $app;

    $total = $app->db->getSumByTotal("amount", "uni_transactions", "status_payment=?", [1]);
    return $app->system->amount($total);

}

public function getTotalProfitToday(){   
    global $app;

    $total = $app->db->getSumByTotal("amount", "uni_transactions", "status_payment=? and date(time_create) = date(now())", [1]);
    return $app->system->amount($total);

}

public function getTotalTransactions(){   
    global $app;

    return $app->model->transactions->count();

}

public function getTotalTransactionsByWeekChart(){   
    global $app;

    $data = [];

    $week[date('Y-m-d')] = date('Y-m-d');

    $currentWeek = date("w",strtotime(date('Y-m-d'))) == 0 ? 7 : date("w",strtotime(date('Y-m-d')));

    if($currentWeek > 1){
        $x=0;
        while ($x++<$currentWeek-1){
           $week[date('Y-m-d', strtotime("-".$x." day"))] = date('Y-m-d', strtotime("-".$x." day"));
        }
    }

    foreach ($week as $key => $value) {
        $amount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=?", [$value]);
        $transactions = $app->model->transactions->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$amount, "title"=>$transactions.' '.endingWord($transactions, translate("tr_5505ce1e01182edbf4e8ef3638b1631e"), translate("tr_8c14745067431da281031a1e21649392"), translate("tr_042fb80f900c76e57c54ee46b36f9ac0"))." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$app->system->amount($amount)];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}

public function initPaymentCart($items_id=[], $delivery_points=[], $user_id=0){
    global $app;

    $items = [];
    $delivery = [];
    $recipient = [];
    $total_amount = 0;
    $delivery_amount = 0;

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    if($items_id){
        $getItems = $app->model->cart->getAll("user_id=? and id IN(".implode(",", $items_id).")", [$user_id]);
        if($getItems){

            foreach ($getItems as $key => $value) {

                $delivery = [];
                $recipient = [];

                $ad = $app->model->ads_data->find("id=?", [$value["item_id"]]);

                if($ad){

                    $total_amount += $ad->price * $value["count"];

                    if($delivery_points[$value["item_id"]]){

                        $data = $app->model->users_delivery_data->find("user_id=?", [$user_id]);

                        if($data){
                            
                            $recipient["name"] = $data->name;
                            $recipient["surname"] = $data->surname; 
                            $recipient["patronymic"] = $data->patronymic; 
                            $recipient["phone"] = decrypt($data->phone); 
                            $recipient["email"] = decrypt($data->email);

                        }else{
                            return ["status"=>false, "answer"=>translate("tr_cfa53f715115000d23c565e2a0dcc2e2")];
                        }

                        $point = $app->model->delivery_points->find("id=?", [$delivery_points[$value["item_id"]]]);
                        
                        if($point){

                            $service = $app->model->system_delivery_services->find("id=? and status=?", [$point->delivery_id, 1]);

                            if($service){
                                if($service->required_price_order){

                                    $calculationDelivery = $app->component->delivery->calculationData($point->id, $value["item_id"], $user_id);

                                    if($calculationDelivery["status"] == true){
                                        $delivery_amount += $calculationDelivery["amount_formatted"];
                                        $total_amount += $calculationDelivery["amount_formatted"];
                                    }else{
                                        return ["status"=>false, "answer"=>translate("tr_f13b2a03ea4f5201bb8000ae9b4a5d30")];
                                    }

                                }
                            }else{
                                return ["status"=>false, "answer"=>translate("tr_f13b2a03ea4f5201bb8000ae9b4a5d30")];
                            }

                            $delivery = ["recipient"=>$recipient,"point_id"=>$point->id,"point_code"=>$point->code,"delivery_id"=>$point->delivery_id];

                        }

                    }

                    $items[] = ["id"=>$ad->id, "cart_item_id"=>$value["id"], "count"=>$value["count"], "price"=>$ad->price, "amount"=>$ad->price * $value["count"], "user_id"=>$ad->user_id, "delivery"=>$delivery];

                }

            }

        }
    }

    if(!$items){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    $params["target"] = "secure_deal";
    $params["order_id"] = generateOrderId();
    $params["items"] = $items;
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["amount"] = round($total_amount,2);
    $params["delivery_amount"] = round($delivery_amount,2);
    $params["payment_id"] = $app->settings->integration_payment_service_secure_deal_active;
    $params["return_url"] = getHost(true) . '/profile/orders';

    return $this->initPaymentService($params["payment_id"], $params);

}

public function initPaymentItem($id=0, $delivery_point_id=0, $user_id=0){
    global $app;

    $recipient = [];
    $total_amount = 0;
    $delivery_amount = 0;

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    $ad = $app->component->ads->getAd($id);

    if(!$ad){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    if($ad->status != 1){
        return ["status"=>false, "answer"=>translate("tr_3b42cb1f87d8b992405ec5fa61bc9d26")];
    }

    if(!$app->component->ads->hasBuySecureDeal($ad)){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    $total_amount = $ad->price;

    if($delivery_point_id){

        $point = $app->model->delivery_points->find("id=?", [$delivery_point_id]);

        if($point){

            $delivery = $app->model->system_delivery_services->find("id=? and status=?", [$point->delivery_id, 1]);

            if($delivery){

                if($app->component->delivery->hasAvailableDelivery($ad,$delivery)){

                    $data = $app->model->users_delivery_data->find("user_id=?", [$user_id]);

                    if($data){
                        
                        $recipient["name"] = $data->name;
                        $recipient["surname"] = $data->surname; 
                        $recipient["patronymic"] = $data->patronymic; 
                        $recipient["phone"] = decrypt($data->phone); 
                        $recipient["email"] = decrypt($data->email);

                        if($delivery->required_price_order){

                            $calculationDelivery = $app->component->delivery->calculationData($delivery_point_id, $id, $user_id);

                            if($calculationDelivery["status"] == true){
                                $delivery_amount = $calculationDelivery["amount_formatted"];
                                $total_amount += $calculationDelivery["amount_formatted"];
                            }else{
                                return ["status"=>false, "answer"=>translate("tr_2b89e0c3b4d50a57dea1e5af357bdaeb")];
                            }

                        }
                        
                    }else{
                        return ["status"=>false, "answer"=>translate("tr_cfa53f715115000d23c565e2a0dcc2e2")];
                    }

                }

            }

        }

    }

    $params["target"] = "secure_deal";
    $params["order_id"] = generateOrderId();
    $params["items"][] = ["id"=>$id, "count"=>1, "price"=>$ad->price, "amount"=>round($ad->price,2), "user_id"=>$ad->user_id, "delivery"=>["recipient"=>$recipient,"point_id"=>(int)$point->id,"point_code"=>$point->code ?: 0,"delivery_id"=>$delivery ? $delivery->id : 0]];
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["amount"] = round($total_amount,2);
    $params["delivery_amount"] = round($delivery_amount,2);
    $params["payment_id"] = $app->settings->integration_payment_service_secure_deal_active;
    $params["return_url"] = getHost(true) . '/profile/orders';

    return $this->initPaymentService($params["payment_id"], $params);

}

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

public function initPaymentService($aliasOrId=null,$params=[]){
    global $app;

    $action = $this->getActionCode($params["target"]);

    $getPayment = $app->model->system_payment_services->find("(alias=? or id=?) and status=?", [$aliasOrId, $aliasOrId, 1]);
    if($getPayment){

        $app->model->transactions_operations->insert(["order_id"=>$params["order_id"],"user_id"=>$params["user_id"],"time_create"=>$app->datetime->getDate(), "data"=>encrypt(_json_encode($params)), "status_processing"=>"awaiting_payment", "currency_code"=>$app->settings->system_default_currency, "amount"=>$params["amount"]]);

        $payment = $app->addons->payment($getPayment->alias)->createPayment(["amount"=>$params["amount"], "order_id"=>$params["order_id"], "title"=>translate("tr_157298fd7045a53d1be4ea9dfe3d91dc")." №".$params["order_id"], "user_name"=>$params["user_name"], "user_phone"=>$params["user_phone"], "user_email"=>$params["user_email"]]);

        if($payment["link"]){
            return ["status"=>true, "link"=>$payment["link"], "order_id"=>$params["order_id"]];
        }else{
            return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
        }

    }else{
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

}

public function initPaymentTarget($payment_id=null,$params=[], $user_id=0){
    global $app;

    if($this->checkCorrectData($params) == false){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    if($params["service_id"]){
        $params["service_data"] = $app->component->ad_paid_services->getServiceData($params["service_id"], $params["count_day"][$params["service_id"]]);
        $order = $app->component->ad_paid_services->getActiveOrder($params["id"], $params["service_id"]);
        if($order){
            return ["status"=>false, "answer"=>translate("tr_3db019a3d6f99b7502794256a806abdb")];
        }
    }elseif($params["tariff_id"]){
        $params["tariff_data"] = $app->component->service_tariffs->getTariffData($params["tariff_id"]);
        $result = $app->component->service_tariffs->checkAddTariff($params["tariff_id"], $user->id);
        if($result){
            return $result;
        }
    }elseif($params["id"]){
        $ad = $app->model->ads_data->find("id=?", [$params["id"]]);
        $params["category_name"] = $app->component->ads_categories->categories[$ad->category_id]["name"];
    }

    $params["order_id"] = generateOrderId();
    $params["amount"] = $this->getPaymentTargetAmount($params);
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["return_url"] = getHost(true);
    $params["payment_id"] = $payment_id;

    if(!$params["amount"]){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    if(!$payment_id){
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

    if($payment_id == "balance" && $app->settings->profile_wallet_status){

        if($user->balance >= $params["amount"]){

            $this->manageUserBalance(["user_id"=>$user->id, "amount"=>$params["amount"]], "-");
            $this->callback($params);

            $app->session->setNotify("success", translate("tr_8ad1afff1d010bb86b13d3c9b7c6cb9d"));

            return ["status"=>true, "update"=>true];
        }else{
            return ["status"=>false, "answer"=>translate("tr_9549a9bae4363d8b5a02d13433be2245")];
        }

    }else{

        return $this->initPaymentService($payment_id,$params);

    }

}

public function initPaymentWallet($params=[], $user_id=0){
    global $app;

    $user = $app->model->users->find("id=?", [$user_id]);
    if(!$user){
        return ["status"=>false, "answer"=>translate("tr_70c884ebf8bb09be0910e4fb00a30b52")];
    }

    $params["target"] = "user_balance";
    $params["order_id"] = generateOrderId();
    $params["amount"] = $params["amount"] ? round($params["amount"],2) : 0;
    $params["user_id"] = $user->id;
    $params["user_name"] = $user->name;
    $params["user_phone"] = $user->phone;
    $params["user_email"] = $user->email;
    $params["return_url"] = getHost(true) . '/profile/wallet';
    
    if(!$params["amount"]){
        return ["status"=>false, "answer"=>translate("tr_5842afafbfb783fefe64321d693b5af5")];
    }else{
        if($params["amount"] < $app->settings->profile_wallet_min_amount_replenishment || $params["amount"] > $app->settings->profile_wallet_max_amount_replenishment){
            return ["status"=>false, "answer"=>translate("tr_a068b723145e72dc2b3ea63b39bae5df")." ".$app->system->amount($app->settings->profile_wallet_min_amount_replenishment)." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$app->system->amount($app->settings->profile_wallet_max_amount_replenishment)];
        }
    }

    if(!$params["payment_id"]){
        return ["status"=>false, "answer"=>translate("tr_5b6c5dcd58c20b12f50335c6d6f10309")];
    }

    return $this->initPaymentService($params["payment_id"], $params);

}

public function manageUserBalance($params=[], $action=null){
    global $app;

    if($params && isset($action)){

        $user = $app->model->users->find("id=?", [$params["user_id"]]);

        if($params["amount"] > 1000000){
            $params["amount"] = 1000000;
        }

        $params["amount"] = round($params["amount"],2);

        if($action == "+"){

            $amount = round($user->balance + $params["amount"], 2);
            $app->model->users->update(["balance"=> $amount], $user->id);
            $app->model->transactions_balance->insert(["user_id"=> $user->id,"amount"=>$params["amount"], "action"=>$action, "action_code"=>"BALANCE_REPLENISHMENT", "time_create"=>$app->datetime->getDate()]);

            $app->event->replenishmentBalanceUser($params);

        }elseif($action == "-"){

            if(round($params["amount"], 2) > round($user->balance, 2)){
                $params["amount"] = round($user->balance,2);
            }

            $amount = round($user->balance - $params["amount"], 2);
            $app->model->users->update(["balance"=> $amount], $user->id);
            $app->model->transactions_balance->insert(["user_id"=> $user->id,"amount"=>$params["amount"], "action"=>$action, "action_code"=>"BALANCE_WRITE_DOWNS", "time_create"=>$app->datetime->getDate()]);

            $app->event->writedownBalanceUser($params);

        }
    }

}

public function optionsPayment($params=[]){
    global $app;

    $amount = $this->getPaymentTargetAmount($params);

    $result = '<form class="option-payment-form" >';

    if($app->settings->profile_wallet_status){
        $result .= '<div class="option-payment-item option-payment-item-change active" data-id="balance" >
        <div class="option-payment-item-logo" ><img src="'.$app->storage->getAssetImage("wallet-6380789.webp").'" /></div> <div class="option-payment-item-name" ><strong>'.translate("tr_f3bffc80fd1707f0e93d8acf0ff2e2e8").'</strong><span>'.translate("tr_6f0f3c9e7ffb8294e60a60cf176efa67").' '.$app->user->data->balance_by_currency.'</span></div>
        <input type="radio" name="payment_id" value="balance" checked="" >
        </div>';
    }

    if($app->settings->integration_payment_services_active){
        $payments = $app->model->system_payment_services->sort("id desc")->getAll("status=? and id IN(".implode(",", $app->settings->integration_payment_services_active).")", [1]);

        if($payments){
            foreach ($payments as $key => $value) {
                $result .= '<div class="option-payment-item option-payment-item-change" data-id="'.$value["alias"].'" for="payment-item-'.$value["alias"].'" >
                <div class="option-payment-item-logo" ><img src="'.$app->addons->payment($value["alias"])->logo().'" /></div> <div class="option-payment-item-name" ><strong>'.$value["name"].'</strong><span>'.$value["title"].'</span></div>
                <input type="radio" name="payment_id" value="'.$value["alias"].'" >
                </div>';
            }
        }
    }

    $result .= '
        <div class="text-end mt-4">
            <button class="btn-custom button-color-scheme1 initTargetPayment" >'.translate("tr_4caffb2a58fc0bd6f790d3e85b054125").' '.$app->system->amount($amount).'</button>
        </div>

        <input type="hidden" name="params" value="'.urlencode(_json_encode($params)).'" />

        </form>
    ';

    return $result;

}

public function outActionsOrderDeal($data=[]){
    global $app;

      if($data->from_user_id == $app->user->data->id){

        if($data->status_processing == "awaiting_confirmation"){

            if(!$data->item->booking_status){
                echo translate("tr_adedfabc674e7efd3d316f4111b58a7b");
                ?>

                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                </div>

                <?php
            }else{
                echo translate("tr_140ab83e84e71d7d537f3f334d67bc25");
                ?>

                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                </div>

                <?php
            }

        }elseif($data->status_processing == "confirmed_order"){

            if(!$data->item->booking_status){

                if($data->item->category->type_goods == "physical_goods"){
                    if($data->delivery_service_id){
                        echo translate("tr_49719417c532c5cb93fb1bcfb64a4ccd");
                    }else{
                        echo translate("tr_b5a0e321d5daa89eecb9e461cfd53cc5");                        
                    }
                }elseif($data->item->category->type_goods == "services"){
                    echo translate("tr_abe06f92ce38481cf4e0a13203d2b053");
                }

            }else{

                echo translate("tr_c5cb17572975ff74c1988fb85bd1df0a");

                ?>
                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme1 initPaymentOrderSecureDeal" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e1f7d614ec62e7651cd1c77c6f3a8afb"); ?></button> 
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                  
                </div> 
                <?php                    

            }

        }elseif($data->status_processing == "access_open"){

            echo translate("tr_409c4a591bae436a2f1f192dc3177d4a")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));

            ?>
            <div class="order-card-section-action-info" >
                <?php echo outTextWithLinks(decrypt($data->item->external_content)); ?>
            </div>                    

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_49eb66b6229f98e4afbe115b412844fe"); ?></button>    
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>               
            </div>                    
            <?php

        }elseif($data->status_processing == "confirmed_send_shipment"){

            ?>

            <div><?php echo translate("tr_3f23e7324e00c06595d0fecb5838fdbd"); ?></div>

            <div class="mt10" ><?php echo translate("tr_bc95f0b22f1d9f54fe526bf39c1b97cc"); ?> <strong><?php echo $data->delivery_service->name; ?></strong> </div>

            <?php if($data->delivery_answer_data["comment_to_recipient"]){ ?>
            <div class="mt10" ><?php echo $data->delivery_answer_data["comment_to_recipient"]; ?></div>
            <?php } ?>

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_88c22e531b9c4cf920aead3329f5bfa6"); ?></button>    
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>               
            </div>

            <?php

        }elseif($data->status_processing == "confirmed_transfer"){

            echo translate("tr_8518db38f8e990fa9ba83bcc1539d00e")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_88c22e531b9c4cf920aead3329f5bfa6"); ?></button>      
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>              
            </div>

            <?php

        }elseif($data->status_processing == "confirmed_completion_service"){

            echo translate("tr_afdfc6e0b45a15e90b586efd5b2adb5b")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_038001628d0014bc8718b42d1405ea18"); ?></button>     
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>              
            </div>

            <?php

        }elseif($data->status_processing == "completed_order"){

            $infoPayment = $this->outInfoPaymentsOrderDeal($data->order_id, $app->user->data->id);

            if($infoPayment){
            ?>
                <div class="order-card-section-action-info" >
                    <?php
                        echo $infoPayment;
                    ?>
                </div>
            <?php
            }

            if($data->item->external_content){
                ?>

                <div class="order-card-section-action-info" >
                    <?php echo outTextWithLinks(decrypt($data->item->external_content)); ?>
                </div> 

                <?php
            }

        }elseif($data->status_processing == "open_dispute"){

            echo translate("tr_572361ee356ac71a2d8b92b04ebcc5e2");
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionCloseDisputeOrderDeal" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_cbcae031aaf24f2be3b3cd22d4d0fb9b"); ?></button>                   
            </div>

            <?php

        }elseif($data->status_processing == "booked"){

            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button> 
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>                  
            </div>

            <?php

        }

      }

      if($data->whom_user_id == $app->user->data->id){

        if($data->status_processing == "awaiting_confirmation"){

            echo translate("tr_33f03b454585b2ff07d9403c30bb434c");

            if($data->delivery_service_id){

                if($data->user_shipping){

                    ?>
                      <div class="order-card-section-action-buttons" >
                         <button class="btn-custom-mini button-color-scheme1 actionChangeStatusOrderDeal" data-status="confirmed_order" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
                         <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                      </div>
                    <?php

                }else{

                    ?>
                      <div class="order-card-section-action-buttons" >
                         <a class="btn-custom-mini button-color-scheme3" href="<?php echo $app->router->getRoute("profile-settings"); ?>?tab=delivery" target="_blank" ><?php echo translate("tr_8947979f1038a8bf293854cec9e73b6a"); ?></a>
                         <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                      </div>
                    <?php

                }

            }else{
            ?>
              <div class="order-card-section-action-buttons" >
                 <button class="btn-custom-mini button-color-scheme1 actionChangeStatusOrderDeal" data-status="confirmed_order" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
                 <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
              </div>
            <?php
            }

        }elseif($data->status_processing == "confirmed_order"){

            if($data->item->category->type_goods == "physical_goods"){

                if(!$data->item->booking_status){
                    if($data->delivery_service_id){
                        ?>

                        <div><?php echo translate("tr_6b39bdae95e723918fb0337826bdcd90"); ?><strong><?php echo $data->user_shipping_point->address; ?>, <?php echo $data->delivery_service->name; ?></strong></div>

                        <?php if($data->delivery_answer_data["comment_to_sender"]){ ?>
                        <div class="mt10" ><?php echo $data->delivery_answer_data["comment_to_sender"]; ?></div>
                        <?php } ?>

                        <div class="order-card-section-action-buttons" >
                           <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>
                           <button class="btn-custom-mini button-color-scheme5 actionChangeStatusOrderDeal" data-status="confirmed_send_shipment" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_d458374e3228a9c45017b98ff1241e86"); ?></button>                   
                        </div>
                        <?php
                    }else{
                        echo translate("tr_25ff13482d796c27b197ad05d7ed522a");
                        ?>
                        <div class="order-card-section-action-buttons" >
                           <button class="btn-custom-mini button-color-scheme5" data-bs-target="#executionModal" data-bs-toggle="modal" ><?php echo translate("tr_eaec2623204b61af4ee3d78d01dae0ce"); ?></button>                   
                        </div>
                        <?php                        
                    }
                }

            }elseif($data->item->category->type_goods == "services"){
                ?>
                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme1" data-bs-target="#executionModal" data-bs-toggle="modal" ><?php echo translate("tr_038001628d0014bc8718b42d1405ea18"); ?></button>                   
                </div>
                <?php
            }

        }elseif($data->status_processing == "access_open"){

            echo translate("tr_90a74c8fc8c8add56d9524f76cce9fd7")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));

        }elseif($data->status_processing == "confirmed_send_shipment"){

            ?>
            <div class="order-card-section-action-info" ><?php echo $app->system->amount($this->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)); ?> <?php echo translate("tr_6f07e1f8fa38e0b51401b846f6d3866c"); ?></div>

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>      
            </div>
            <?php 

        }elseif($data->status_processing == "confirmed_transfer" || $data->status_processing == "confirmed_completion_service"){

            ?>
            <div class="order-card-section-action-info" ><?php echo $app->system->amount($this->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)); ?> <?php echo translate("tr_1eb131f3df87d0b96aa2670c059c1bd7") . ' ' . $app->settings->secure_deal_auto_closing_time . ' ' . endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")); ?></div>
            <?php 

        }elseif($data->status_processing == "completed_order"){

            $infoPayment = $this->outInfoPaymentsOrderDeal($data->order_id, $app->user->data->id);

            if($infoPayment){
            ?>
            <div class="order-card-section-action-info" >
                <?php
                    echo $infoPayment;
                ?>
            </div>
            <?php
            }

        }elseif($data->status_processing == "open_dispute"){

            echo translate("tr_572361ee356ac71a2d8b92b04ebcc5e2");

        }

      }

}

public function outActivePaymentsInWallet(){
    global $app;

    $result  = '';

    if($app->settings->integration_payment_services_active){
        $payments = $app->model->system_payment_services->sort("id desc")->getAll("status=? and id IN(".implode(",", $app->settings->integration_payment_services_active).")", [1]);

        if($payments){
            foreach ($payments as $key => $value) {
                $result .= '<div class="option-payment-item option-payment-item-change-wallet '.($key == 0 ? 'active' : '').'" data-id="'.$value["alias"].'" >
                <div class="option-payment-item-logo" ><img src="'.$app->addons->payment($value["alias"])->logo().'" /></div> <div class="option-payment-item-name" ><strong>'.$value["name"].'</strong><span>'.$value["title"].'</span></div> 
                <input type="radio" name="payment_id" value="'.$value["alias"].'" '.($key == 0 ? 'checked=""' : '').' >
                </div>';
            }
        }
    }

    return $result;

}

public function outHistoryDeal($order_id=null){
    global $app;

    $getHistory = $app->model->transactions_deals_history->sort("id desc")->getAll("order_id=? and (user_id=? or user_id=?)", [$order_id, 0, $app->user->data->id]);

    if($getHistory){
        foreach ($getHistory as $key => $value) {
            ?>

            <div class="timeline-action-item">
              <div class="timeline-action-item-point"></div>
              <div class="timeline-action-item-event">
                
                <div class="timeline-action-item-header">
                  <h6 class="mb-0"><?php echo $this->getHistoryCode($value["action_code"])->name; ?></h6>
                  <small class="text-muted"><?php echo $app->datetime->outDateTime($value["time_create"]); ?></small>
                </div>

                <?php if($value["comment"]){ ?>
                <p class="mb-0 mt-1"><?php echo $value["comment"]; ?></p>
                <?php }

                if($value["media"]){
                    ?>
                    <div class="timeline-action-media uniMediaSliderContainer" >
                    <?php
                    foreach (_json_decode($value["media"]) as $key => $media_item) {
                        ?>
                        <a class="timeline-action-media-item uniMediaSliderItem" href="<?php echo $app->storage->name($media_item)->host(true)->get(); ?>" data-media-key="<?php echo $key; ?>" data-media-type="image" ><img src="<?php echo $app->storage->name($media_item)->host(true)->get(); ?>" class="image-autofocus" /></a>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }

                ?>
              </div>
            </div>

            <?php
        }
    }

}

public function outInfoPaymentsOrderDeal($order_id=0, $user_id=0){
    global $app;

    $getPayment = $app->model->transactions_deals_payments->find("order_id=? and whom_user_id=?", [$order_id, $user_id]);

    if($getPayment){
        if($getPayment->status_processing == "awaiting_payment"){

            return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 

        }elseif($getPayment->status_processing == "done"){

            return $app->system->amount($getPayment->amount) . ' ' . translate("tr_95231d935ffb9f48fd901c46e92676f7");

        }elseif($getPayment->status_processing == "no_score"){

            return translate("tr_ca6482e97550b5bd24f16d04d7e711a5").' <div><button class="btn-custom-mini button-color-scheme5 mt10" data-bs-target="#addPaymentScoreModal" data-bs-toggle="modal" >'.translate("tr_dcaa92e2ddc6a6305e3592910fee8df6").'</button> </div>';

        }elseif($getPayment->status_processing == "payment_error"){

            if($getPayment->comment && $getPayment->user_show_error){
                return $getPayment->comment; 
            }else{
                return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 
            }

        }
    }

}

public function outStatisticsListProfitByMonth($month=null,$year=null){
    global $app;

    $result = "";

    if(!$year){
        $year = $app->datetime->format("Y")->getDate();
    }

    if(!$month){
        $month = abs($app->datetime->format("m")->getDate());
    }

    $x=0;
    while ($x++<12){

       $active = "";

       if(compareValues($year.'-'.$month, $year.'-'.$x)){
            $active = "active";
       }

       $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "year(time_create)=? and month(time_create)=? and status_payment=?", [$year,$x,1]);

       $result .= '
           <a class="transactions-statistics-month-list-item '.$active.'" href="?month='.$x.'&year='.$year.'" >
             <strong>'.$app->datetime->getCurrentNameMonth($x).', '.$year.'</strong>
             <span>'.$app->system->amount($getAmount).'</span>
           </a>
       ';

    }

    return $result;

}

public function outStatisticsListYears($year=null){
    global $app;

    $result = "";

    $x=2015;
    while ($x++<2050){

       $result .= '
          <li>
            <a class="dropdown-item" href="'.requestBuildVars(["month"=>abs($app->datetime->format("m")->getDate()),"year"=>$x]).'" >
              <span>'.$x.'</span>
            </a>
          </li>
       ';

    }

    return $result;

}

public function paymentCardAdd($user_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment){
        return $app->addons->payment($payment->alias)->addCard(["user_id"=>$user_id]);
    }

    return ["status"=>false];

}

public function paymentCardDelete($user_id=0, $card_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment){
        return $app->addons->payment($payment->alias)->deleteCard(["user_id"=>$user_id, "card_id"=>$card_id]);
    }

    return ["status"=>false];

}

public function paymentRefund($data=[]){
    global $app;

    if($data){

        $data->operation = $this->getOperation($data->operation_id);

        if($data->operation->status_processing == "paid"){

            $app->model->transactions_operations->insert(["order_id"=>$data->order_id,"user_id"=>$data->from_user_id,"time_create"=>$app->datetime->getDate(), "data"=>encrypt(_json_encode($data->operation->data)), "status_processing"=>"awaiting_refund", "currency_code"=>$data->operation->currency_code, "amount"=>$data->amount, "callback_data"=>$data->operation->callback_data ? encrypt(_json_encode($data->operation->callback_data)) : null]);

            $app->addons->payment($data->operation->data["payment_id"])->createRefund($data);

            foreach ($data->operation->data["items"] as $key => $value) {
                $this->warehouseItem($value["id"],$value["count"],"+");
            }

        }

    }

}

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

public function statusesDeal(){   
    global $app;

    $result["awaiting_confirmation"] = ["code"=>"awaiting_confirmation", "name"=>translate("tr_f4636fd16e2df3445885f06db1a06d9c"), "label"=>"secondary"];
    $result["confirmed_order"] = ["code"=>"confirmed_order", "name"=>translate("tr_361a6154ef972d6614ecc80b9acf7d2e"), "label"=>"success"];
    $result["confirmed_send_shipment"] = ["code"=>"confirmed_send_shipment", "name"=>translate("tr_e245d6ddf9eb6c8222c2ec39471ee4e1"), "label"=>"warning"];
    $result["confirmed_transfer"] = ["code"=>"confirmed_transfer", "name"=>translate("tr_a856a106ecccf40ec49b1b6f45d1618d"), "label"=>"success"];
    $result["confirmed_completion_service"] = ["code"=>"confirmed_completion_service", "name"=>translate("tr_1db8895111a4f059392893d800a3c8f1"), "label"=>"warning"];
    $result["access_open"] = ["code"=>"access_open", "name"=>translate("tr_1c4d017c1c6df12c58500bd0de14d58a"), "label"=>"success"];
    $result["completed_order"] = ["code"=>"completed_order", "name"=>translate("tr_245743d5301f067be6cb6ae479a9da7f"), "label"=>"success"];
    $result["cancel_order"] = ["code"=>"cancel_order", "name"=>translate("tr_c302fdafed8f284641ebf94309d38559"), "label"=>"danger"];
    $result["open_dispute"] = ["code"=>"open_dispute", "name"=>translate("tr_e1fc430809c38206dce521425fcf125f"), "label"=>"warning"];
    $result["booked"] = ["code"=>"booked", "name"=>translate("tr_793cfdfa7d5f3f9792e337cc6623dca1"), "label"=>"success"];
    return $result;

}

public function statusesDealPayment(){   
    global $app;

    $result["awaiting_payment"] = ["code"=>"awaiting_payment", "name"=>translate("tr_1f1016ebd265f71f6cf4c8e61fcf4e33"), "label"=>"warning"];
    $result["done"] = ["code"=>"done", "name"=>translate("tr_188d7d98dd1b53c85b203f802e1fdf86"), "label"=>"success"];
    $result["no_score"] = ["code"=>"no_score", "name"=>translate("tr_5557733260d5065a26cfef9addeba834"), "label"=>"warning"];
    $result["payment_error"] = ["code"=>"payment_error", "name"=>translate("tr_f53c9b2f925be0923418892c449b56d4"), "label"=>"danger"];

    return $result;

}

public function statusesOperation(){   
    global $app;

    $result["awaiting_payment"] = ["code"=>"awaiting_payment", "name"=>translate("tr_47f1f18a961cd149db1dc53ba4b31b37"), "label"=>"warning"];
    $result["paid"] = ["code"=>"paid", "name"=>translate("tr_6d8c0850821a806217ea219a53500d7e"), "label"=>"success"];
    $result["awaiting_refund"] = ["code"=>"awaiting_refund", "name"=>translate("tr_70bd7e5b717141e953d88d9f553e6e38"), "label"=>"warning"];
    $result["refund"] = ["code"=>"refund", "name"=>translate("tr_528182826de2acb5dbb4957010d182f1"), "label"=>"warning"];
    $result["error"] = ["code"=>"error", "name"=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"), "label"=>"danger"];
    return $result;

}

public function warehouseItem($item_id=0,$count=0,$action=null){
    global $app;

    $getAd = $app->model->ads_data->find("id=?", [$item_id]);

    if(!$getAd->not_limited){

        if($action == "-"){

            $count = abs($getAd->in_stock - $count);

            if($count){
                $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>$count], $item_id);
            }else{
                $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>0, "status"=>7], $item_id);
            }

        }elseif($action == "+"){

            $count = $getAd->in_stock + $count;

            $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>$count, "status"=>1], $item_id);

        }

    }

}



}