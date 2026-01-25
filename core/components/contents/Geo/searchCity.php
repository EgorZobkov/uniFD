public function searchCity($query=null){
    global $app;

    $results = [];
    $items = "";

    if(_mb_strlen($query) < 2 || !$app->settings->active_countries){
        return (object)["items"=>$items, "results"=>$results];
    }

    if($query){

        $cities = $app->model->geo_cities->cacheKey(["search"=>$query, "country_id"=>implode(",",$app->settings->active_countries)])->search($query)->sort("name asc limit 100")->getAll("country_id IN(".implode(",",$app->settings->active_countries).")");

        if($cities){
            foreach ($cities as $key => $value) {
                $value = $this->getCityDataByValue($value);
                $results[] = $value;
                $items .= '<span data-id="'.$value["id"].'" data-latitude="'.$value["latitude"].'" data-longitude="'.$value["longitude"].'" class="geo-city-item" >'.$this->outFullNameCity($value).'</span>';
            }
        }

    }

    return (object)["items"=>$items, "results"=>$results];

}