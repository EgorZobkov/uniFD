public function getActiveServicesByAd($ad_id=0){
    global $app;

    $result = [];
    $ids = [];
    $aliases = [];
    $result_by_alias = [];

    $getOrders = $app->model->ads_services_orders->getAll("ad_id=? and time_expiration > now()", [$ad_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {

            $getService = $app->model->ads_services->getRow("id=?", [$value["service_id"]]);

            $ids[] = $value["service_id"];
            $aliases[] = $getService["alias"];

            $result[] = arrayToObject(["order"=>$value, "service"=>$getService]);
            $result_by_alias[$getService["alias"]] = arrayToObject(["order"=>$value, "service"=>$getService]);

        }
    }

    return (object)["ids"=>$ids,"aliases"=>$aliases, "data"=>$result, "data_by_alias"=>$result_by_alias];       

}