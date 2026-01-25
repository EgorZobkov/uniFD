public function tariffNotifications(){

    $getOrders = $this->model->users_tariffs_orders->sort("id asc limit 500")->getAll("now() < time_expiration and unix_timestamp(now()) + 3600 >= unix_timestamp(time_expiration) and status=?", [1]);

    if($getOrders){

        foreach ($getOrders as $value) {
            $this->notify->params([])->userId($value["user_id"])->code("soon_service_tariff_end_term")->addWaiting();
        }

    }

}