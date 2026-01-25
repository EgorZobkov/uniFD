public function getRegionDataByValue($value=[]){
    global $app;

    if($value){

        $value["country"] = $app->model->geo_countries->cacheKey(["id"=>$value["country_id"]])->getRow("id=?", [$value["country_id"]]);

        return $value;

    }

    return [];

}