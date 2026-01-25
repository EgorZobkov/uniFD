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