public function searchItemsWaitingList($query=null, $user_id=0){
    global $app;

    $items = '';
    $ids = [];

    $getOrders = $app->model->ads_services_orders->getAll("user_id=? and time_expiration > now()", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
            $getService = $app->model->ads_services->find("id=?", [$value["service_id"]]);
            if($getService->alias == "package"){
                $ids[] = $value["ad_id"];
            }
        }
    }

    if($ids){
        $getItems = $app->model->ads_data->sort("id desc limit 50")->search($query)->getAll("id NOT IN(".implode(",", $ids).") and user_id=? and status=?", [$user_id,1]);
    }else{
        $getItems = $app->model->ads_data->sort("id desc limit 50")->search($query)->getAll("user_id=? and status=?", [$user_id,1]);
    }

    if($getItems){

        foreach ($getItems as $key => $value) {

            $array_images = $app->component->ads->getMedia($value["media"]);

            $items .= '
                <a class="ad-paid-services-ads-item" href="'.outRoute("ad-services", [$value["id"]]).'" >
                
                 <div class="ad-paid-services-ads-item-image" > <img src="'.$array_images->images->first.'" class="image-autofocus" > </div>
                 <div class="ad-paid-services-ads-item-title" > '.$value["title"].' </div>

                </a>
            ';
        }

    }

    if($items){
        return $items;
    }else{
        return '<div>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
    }

}