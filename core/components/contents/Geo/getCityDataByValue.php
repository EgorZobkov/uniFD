public function getCityDataByValue($value=[]){
    global $app;

    if($value){

        $value["country"] = $app->model->geo_countries->cacheKey(["id"=>$value["country_id"]])->getRow("id=?", [$value["country_id"]]);
        $value["region"] = $app->model->geo_regions->cacheKey(["id"=>$value["region_id"]])->getRow("id=?", [$value["region_id"]]);

        return $value;

    }

    return [];

}