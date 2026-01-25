public function searchCombined($query=null, $country_id=0){
    global $app;

    $results = '';
    $regions = [];
    $cities = [];
    $regions_ids = [];

    if(!$app->settings->active_countries){
        return json_answer(["status"=>false]);
    }

    if(!$country_id){
        if($this->getChange()->country_id){
            $country_id = $this->getChange()->country_id;
        }else{
            $country_id = $this->defaultCountry->id ?: 0;
        }
    }

    if($country_id){
        $country = $app->model->geo_countries->find("id=? and status=?", [$country_id, 1]);
        if(!$country){
            return json_answer(["status"=>false]);
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

                $cities[] = $this->getCityDataByValue($value);

                if($value["region_id"]){
                    $regions_ids[] = $value["region_id"];
                }

            }

            if($regions_ids){

                $getRegions = $app->model->geo_regions->cacheKey(["id"=>implode(",",$regions_ids)])->sort("name asc")->getAll("id IN(".implode(",",$regions_ids).")");

                if($getRegions){

                    foreach ($getRegions as $key => $value) {
                        $regions[] = $this->getRegionDataByValue($value);
                    }

                }

            }

        }else{

            $getRegions = $app->model->geo_regions->cacheKey(["query"=>$query, "country_id"=>$country_id, "status"=>1])->search($query, $query_fields)->sort("name asc limit 50")->getAll("country_id=? and status=?", [$country_id,1]);

            if($getRegions){

                foreach ($getRegions as $key => $value) {

                    $regions[] = $this->getRegionDataByValue($value);
  
                }

            }

        }

        if($cities){
            foreach ($cities as $key => $value) {
                $results .= '
                    <a href="'.$this->replaceAliases($value).'" data-id="'.$value["id"].'" data-purpose="city" class="link-geo-item" >'.$this->outFullNameCity($value).' </a>
                ';
            }
        }

        if($regions){
            foreach ($regions as $key => $value) {
                $results .= '
                    <a href="'.$this->replaceAliases($value).'" data-id="'.$value["id"].'" data-purpose="region" class="link-geo-item" >'.translateFieldReplace($value, "name").'</a>
                ';
            }                
        }

        if($app->component->geo->statusMultiCountries()){

            $results .= '
                <a href="'.$this->replaceAllCitiesByCountry($country->alias).'" data-purpose="country" data-id="'.$country_id.'" class="link-geo-item" >'.translate("tr_9a73b1e5b44bee481ab175b7e327451e").'</a>
            ';

        }else{

            $results .= '
                <a href="'.$this->replaceAllCities().'" data-purpose="all" class="link-geo-item" >'.translate("tr_9a73b1e5b44bee481ab175b7e327451e").'</a>
            ';

        }

    }

    if($results){
        return json_answer(["status"=>true, "answer"=>'<div>'.$results.'</div>']);
    }else{
        return json_answer(["status"=>false]);
    }

}