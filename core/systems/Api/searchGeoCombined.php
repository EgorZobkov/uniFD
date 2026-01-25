public function searchGeoCombined($query=null, $country_id=0){
    global $app;

    $result = [];
    $regions_ids = [];

    if(!$app->settings->active_countries){
        return [];
    }

    $country_id = $country_id ?: $app->component->geo->defaultCountry->id;

    if($country_id){
        $country = $app->model->geo_countries->find("id=? and status=?", [$country_id, 1]);
        if(!$country){
            return [];
        }
    }

    if(isset($query)){

        $query_fields[] = 'name';

        if($app->translate->fieldReplace("name")){
            $query_fields[] = $app->translate->fieldReplace("name");
        }

        $getCities = $app->model->geo_cities->cacheKey(["query"=>$query, "country_id"=>$country_id, "status"=>1])->search($query, $query_fields)->sort("name asc limit 50")->getAll("country_id=? and status=?", [$country_id,1]);

        if($getCities){

            foreach ($getCities as $key => $value) {

                $result[] = ["name"=>$app->component->geo->outFullNameCity($value), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "region_name"=>translateFieldReplace($value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$value["id"], "region_id"=>$value["region_id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];

                if($value["region_id"]){
                    $regions_ids[] = $value["region_id"];
                }

            }

            if($regions_ids){

                $getRegions = $app->model->geo_regions->cacheKey(["id"=>implode(",",$regions_ids)])->sort("name asc")->getAll("id IN(".implode(",",$regions_ids).")");

                if($getRegions){

                    foreach ($getRegions as $key => $value) {
                        $result[] = ["name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>0, "region_id"=>$value["id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
                    }

                }

            }

        }else{

            $getRegions = $app->model->geo_regions->cacheKey(["query"=>$query, "country_id"=>$country_id, "status"=>1])->search($query, $query_fields)->sort("name asc limit 50")->getAll("country_id=? and status=?", [$country_id,1]);

            if($getRegions){

                foreach ($getRegions as $key => $value) {

                    $result[] = ["name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>0, "region_id"=>$value["id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
  
                }

            }

        }

    }

    return $result;

}