public function getCityData($city_id=0){
    global $app;

    if(!$city_id || !$app->settings->active_countries){
        return [];
    }

    $data = $app->model->geo_cities->cacheKey(["id"=>$city_id])->getRow("id=? and status=? and country_id IN(".implode(",",$app->settings->active_countries).")", [$city_id,1]);
    if($data){
        $data["country"] = $app->model->geo_countries->cacheKey(["id"=>$data["country_id"]])->getRow("id=?", [$data["country_id"]]);
        $data["region"] = $app->model->geo_regions->cacheKey(["id"=>$data["region_id"]])->getRow("id=?", [$data["region_id"]]);
    }

    return arrayToObject($data);

}