public function outItemsWaitingList($item_id=0, $user_id=0, $output=50){
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
        $getItems = $app->model->ads_data->getAll("id NOT IN(".implode(",", $ids).") and user_id=? and status=? order by id desc limit ?", [$user_id,1,intval($output)]);
    }else{
        $getItems = $app->model->ads_data->getAll("user_id=? and status=? order by id desc limit ?", [$user_id,1,intval($output)]);
    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            $active = '';

            $array_images = $app->component->ads->getMedia($value["media"]);

            if($item_id == $value["id"]){
                $active = 'active';
            }

            $items .= '
                <a class="ad-paid-services-ads-item '.$active.'" href="'.outRoute("ad-services", [$value["id"]]).'" >
                
                 <div class="ad-paid-services-ads-item-image" > <img src="'.$array_images->images->first.'" class="image-autofocus" > </div>
                 <div class="ad-paid-services-ads-item-title" > '.$value["title"].' </div>

                </a>
            ';
        }

        return '
        <div class="ad-paid-services-ads-container" >
        <p>'.count($getItems).' '.endingWord(count($getItems), translate("tr_9fb3c8f80c97b33ef42bbc8c05b1318e"),translate("tr_bb66218008cb14902539f6d6d25cf4f2"),translate("tr_3a56c05cec9c49dbbf159eea4b5fe61e")).'</p>
        <input class="form-control" placeholder="'.translate("tr_c4e13f3e179240627dcb0ef7c41ca3d4").'" />
        <div class="ad-paid-services-ads-list" >'.$items.'</div>
        </div>';

    }

}