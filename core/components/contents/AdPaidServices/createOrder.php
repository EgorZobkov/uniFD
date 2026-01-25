public function createOrder($params=[]){
    global $app;

    $getService = $app->model->ads_services->find("id=?", [$params["service_id"]]);

    if($getService->count_day_fixed){
        $count_day = $getService->count_day;
    }else{
        $count_day = $params["count_day"];
    }

    $params["time_create"] = $app->datetime->getDate();
    $params["time_expiration"] = $app->datetime->addDay($count_day)->getDate();

    $app->model->ads_services_orders->insert($params);

    $this->activation($getService->alias, $params["ad_id"], $count_day);

    $app->event->addPaidService($params);        

}