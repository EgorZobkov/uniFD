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