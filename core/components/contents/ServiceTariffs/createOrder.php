public function createOrder($params=[]){
    global $app;

    $count_day = 0;

    $getTariff = $app->model->users_tariffs->find("id=?", [$params["tariff_id"]]);
    if($getTariff->count_day_fixed){
        $count_day = $getTariff->count_day;
    }

    $order = $this->getActiveOrder($params["user_id"]);

    if($order){
        if($order->tariff_id == $params["tariff_id"]){

            $time_expiration = $app->datetime->addDay($count_day)->getDate($order->time_expiration);

            $app->model->users_tariffs_orders->update(["time_expiration"=>$time_expiration, "status"=>1], $order->id);

            $app->event->extendServiceTariff($params);

            return;

        }
    }

    $params["time_create"] = $app->datetime->getDate();
    $params["time_expiration"] = $count_day ? $app->datetime->addDay($count_day)->getDate() : null;
    $params["count_day"] = $count_day;
    $params["status"] = 1;

    $app->model->users_tariffs_orders->delete("user_id=?", [$params["user_id"]]);
    $app->model->users_tariffs_orders->insert($params);
    $app->model->users->update(["tariff_id"=>$params["tariff_id"]], $params["user_id"]);

    $tariff = $app->component->service_tariffs->getOrderByUserId($params["user_id"]);

    if($tariff->items->shop){
        $shop = $app->component->shop->getShopByUserId($params["user_id"]);
        if($shop){
            $app->model->shops->update(["status"=>"published"], ["user_id=? and status=?", [$params["user_id"], "blocked"]]);
        }
    }

    if($getTariff->onetime){
        $app->model->users_tariffs_onetime->insert(["user_id"=>$params["user_id"], "tariff_id"=>$params["tariff_id"]]);
    }

    $app->event->addServiceTariff($params);        

}