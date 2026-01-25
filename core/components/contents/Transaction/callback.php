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