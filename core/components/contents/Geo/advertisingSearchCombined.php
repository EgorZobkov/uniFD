public function advertisingSearchCombined($query=null){
    global $app;

    $results = '';
    $regions = [];
    $cities = [];
    $regions_ids = [];

    if(!$app->settings->active_countries){
        return json_answer(["status"=>false]);
    }

    if(isset($query)){

        $getCities = $app->model->geo_cities->search($query, ['name'])->sort("name asc limit 50")->getAll("country_id IN(".implode(",", $app->settings->active_countries).") and status=?", [1]);

        if($getCities){

            foreach ($getCities as $key => $value) {

                $cities[] = $this->getCityDataByValue($value);

                if($value["region_id"]){
                    $regions_ids[] = $value["region_id"];
                }

            }

            if($regions_ids){

                $getRegions = $app->model->geo_regions->sort("name asc")->getAll("id IN(".implode(",",$regions_ids).")");

                if($getRegions){

                    foreach ($getRegions as $key => $value) {
                        $regions[] = $this->getRegionDataByValue($value);
                    }

                }

            }

        }else{

            $getRegions = $app->model->geo_regions->search($query)->sort("name asc limit 50")->getAll("country_id IN(".implode(",", $app->settings->active_countries).") and status=?", [1]);

            if($getRegions){

                foreach ($getRegions as $key => $value) {

                    $regions[] = $this->getRegionDataByValue($value);
  
                }

            }

        }

        if($cities){
            foreach ($cities as $key => $value) {
                $results .= '
                    <span class="advertising-geo-search-results-item" data-id="'.$value["id"].'" data-name="'.translateFieldReplace($value, "name").'" data-purpose="city" >'.$this->outFullNameCity($value).'</span>
                ';
            }
        }

        if($regions){
            foreach ($regions as $key => $value) {
                $results .= '
                    <span class="advertising-geo-search-results-item" data-id="'.$value["id"].'" data-name="'.translateFieldReplace($value, "name").'" data-purpose="region" >'.translateFieldReplace($value, "name").'</span>
                ';
            }                
        }

    }

    $getCountries = $app->model->geo_countries->sort("name asc")->getAll("id IN(".implode(",", $app->settings->active_countries).") and status=?", [1]);

    if($getCountries){
        foreach ($getCountries as $key => $value) {

            $results .= '
                <span class="advertising-geo-search-results-item" data-id="'.$value["id"].'" data-name="'.translateFieldReplace($value, "name").'" data-purpose="country" >'.translateFieldReplace($value, "name").'</span>
            ';

        }
    }

    if($results){
        return json_answer(["status"=>true, "answer"=>'<div>'.$results.'</div>']);
    }else{
        return json_answer(["status"=>false]);
    }

}