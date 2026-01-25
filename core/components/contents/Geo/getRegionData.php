public function getRegionData($region_id=0){
    global $app;

    if(!$app->settings->active_countries){
        return [];
    }

    $data = $app->model->geo_regions->cacheKey(["id"=>$region_id])->getRow("id=? and status=? and country_id IN(".implode(",",$app->settings->active_countries).")", [$region_id,1]);
    if($data){
        $data["country"] = $app->model->geo_countries->cacheKey(["id"=>$data["country_id"]])->getRow("id=?", [$data["country_id"]]);
    }

    return arrayToObject($data);

}