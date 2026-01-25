public function getServiceData($service_id=0, $count=1){
    global $app;

    $getService = $app->model->ads_services->find("id=? and status=?", [$service_id,1]);
    if($getService){

        if($getService->count_day_fixed){
            return ["count"=>$getService->count_day, "amount"=>$getService->price, "name"=>translateFieldReplace($getService, "name")];
        }else{
            return ["count"=>abs(intval($count)), "amount"=>$getService->price * abs(intval($count)), "name"=>translateFieldReplace($getService, "name")];
        }

    }

    return [];

}