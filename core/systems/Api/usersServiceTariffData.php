public function usersServiceTariffData($user_id=0, $tariff_id=0){
    global $app;

    $items = [];
    $order = (object)[];

    if($tariff_id){

        $tariff = $app->model->users_tariffs->find("id=?", [$tariff_id]);

        if($tariff){

            $order = $app->model->users_tariffs_orders->find("user_id=?", [$user_id]);

            if($order){

                if(strtotime($order->time_expiration) > time() || $order->time_expiration == null){

                    $order->expiration_status = true;

                    $order->expiration_date = translate("tr_bec32eadbabac6fae71dbe1b9e4912bc") . ' ' . date("d.m.Y", strtotime($order->time_expiration));

                    if($tariff->items_id){
                        $items = $app->model->users_tariffs_items->getAll("id IN(".implode(",", _json_decode($tariff->items_id)).")");
                        if($items){
                            foreach ($items as $value) {
                                $order->items[$value["code"]] = true;
                            }
                        }
                    }

                }else{
                    $order->expiration_status = false;
                }

                $order->data = (array)$tariff;
                return (array)$order;

            }else{
                $order = (object)[];
                $order->data = (array)$tariff;
                $order->expiration_status = false;
            }

        }

    }

    return (array)$order;

}