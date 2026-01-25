public function getOrderByUserId($user_id=0){
    global $app;

    $items = [];
    $order = $app->model->users_tariffs_orders->find("user_id=?", [$user_id]);

    if($order){

        $order->data = $app->model->users_tariffs->find("id=?", [$order->tariff_id]);

        if($order->data){

            $order->data->count_day_and_ending_word = $order->data->count_day . ' ' . endingWord($order->data->count_day, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"));

            if(strtotime($order->time_expiration) > time() || $order->time_expiration == null){

                $order->expiration_status = true;
                $order->expiration_date = $order->time_expiration ? translate("tr_5192bdb7a058b0b2f9272d8696050d12") . ' ' . $app->datetime->outDateTime($order->time_expiration) : translate("tr_5459e68fa4cdc4e9c0907f030f976a5a");

                if($order->data->items_id){
                    $items = $app->model->users_tariffs_items->getAll("id IN(".implode(",", _json_decode($order->data->items_id)).")");
                    if($items){
                        foreach ($items as $value) {
                            $order->items[$value["code"]] = true;
                        }
                    }
                }

            }else{
                $order->expiration_status = false;
            }

        }else{
            $order->expiration_status = false;
        }

        return arrayToObject($order);
    }

    return [];

}