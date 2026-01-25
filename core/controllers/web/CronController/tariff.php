public function tariff(){

    $ids = [];
    $user_ids = [];

    $getOrders = $this->model->users_tariffs_orders->sort("id asc limit 500")->getAll("time_expiration is not null and now() >= time_expiration and status=?", [1]);

    if($getOrders){

        foreach ($getOrders as $value) {
            $ids[] = $value["id"];
            $user_ids[] = $value["user_id"];
            $this->notify->params([])->userId($value["user_id"])->code("service_tariff_end_term")->addWaiting();
        }

        $this->model->users_tariffs_orders->update(["status"=>0], ["id IN(".implode(",", $ids).")", []]);

        $this->model->shops->update(["status"=>"blocked"], ["user_id IN(".implode(",", $user_ids).")", []]);

    }

}