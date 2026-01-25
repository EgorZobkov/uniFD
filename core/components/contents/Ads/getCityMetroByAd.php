public function getCityMetroByAd($ad_id=0){
    global $app;

    $ids = [];
    $data = [];

    $get = $app->model->ads_city_metro_ids->getAll("ad_id=?", [$ad_id]);
    if($get){
        foreach ($get as $key => $value) {
            $ids[] = $value["metro_id"];
        }
        $data = $app->model->geo_cities_metro->getAll("id IN(".implode(",", $ids).")");
    }

    return (object)["ids"=>$ids, "data"=>$data];

}