public function outFavoritesCities($country_id=0){
    global $app;

    $result = '';

    if(!$country_id){
        if($this->getChange()->country_id){
            $country_id = $this->getChange()->country_id;
        }else{
            if($this->defaultCountry){
                $country_id = $this->defaultCountry->id;
            }
        }
    }

    $country = $app->model->geo_countries->find("id=? and status=?", [$country_id, 1]);
    if(!$country){
        return $result;
    }

    $cities = $app->model->geo_cities->sort("name asc limit 20")->getAll("favorite=? and status=? and country_id=?", [1,1,$country_id]);

    if($app->component->geo->statusMultiCountries()){

        $result .= '
            <div class="col-md-6" ><a href="'.$this->replaceAllCitiesByCountry($country->alias).'" data-purpose="country" data-id="'.$country_id.'" class="link-geo-item" >'.translate("tr_9a73b1e5b44bee481ab175b7e327451e").'</a></div>
        ';

    }else{
        $result .= '
            <div class="col-md-6" ><a href="'.$this->replaceAllCities().'" data-purpose="all" class="link-geo-item" >'.translate("tr_9a73b1e5b44bee481ab175b7e327451e").'</a></div>
        ';            
    }

    if($cities){

        foreach ($cities as $key => $value) {

            $value = $this->getCityDataByValue($value);

            $result .= '
                <div class="col-md-6" ><a href="'.$this->replaceAliases($value).'" data-id="'.$value["id"].'" data-purpose="city" class="link-geo-item" >'.translateFieldReplace($value, "name").'</a></div>
            ';

        }

    }

    return $result;

}