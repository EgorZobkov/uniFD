public function importSearchCity($query=null){
    global $app;

    $results = "";
    $items = "";

    if(_mb_strlen($query) < 2 || !$app->settings->active_countries){
        return '<div class="container-live-search-no-results" >'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
    }

    if($query){

        $cities = $app->model->geo_cities->cacheKey(["search"=>$query, "country_id"=>implode(",",$app->settings->active_countries)])->search($query)->sort("name asc limit 100")->getAll("country_id IN(".implode(",",$app->settings->active_countries).")");

        if($cities){
            foreach ($cities as $key => $value) {
                $value = $this->getCityDataByValue($value);
                $results .= '<span class="container-live-search-results-item container-live-search-results-item-city" data-id="'.$value["id"].'" data-city-name="'.$value["name"].'" >'.$this->outFullNameCity($value).'</span>';
            }
        }else{
            $results = '<div class="container-live-search-no-results" >'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
        }

    }

    return $results;

}