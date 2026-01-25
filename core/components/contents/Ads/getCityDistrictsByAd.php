public function getCityDistrictsByAd($ad_id=0){
    global $app;

    $ids = [];
    $data = [];

    $get = $app->model->ads_city_districts_ids->getAll("ad_id=?", [$ad_id]);
    if($get){
        foreach ($get as $key => $value) {
            $ids[] = $value["district_id"];
        }
        $data = $app->model->geo_cities_districts->getAll("id IN(".implode(",", $ids).")");
    }

    return (object)["ids"=>$ids, "data"=>$data];

}