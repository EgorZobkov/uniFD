public function searchCity($query=null, $country_id=0){
    global $app;

    $result = [];

    $country_id = $country_id ?: $app->component->geo->defaultCountry->id;

    if(_mb_strlen($query) < 2 || !$app->settings->active_countries){
        return [];
    }

    if($query){

        $cities = $app->model->geo_cities->cacheKey(["search"=>$query, "country_id"=>$country_id])->search($query)->sort("name asc limit 100")->getAll("country_id=?", [$country_id]);

        if($cities){
            foreach ($cities as $key => $value) {
                $result[] = ["name"=>$app->component->geo->outFullNameCity($value), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>$value["name"], "region_name"=>translateFieldReplace($value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$value["id"], "region_id"=>$value["region_id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
            }
        }

    }

    return $result;

}