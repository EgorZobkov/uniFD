<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Geo
{

 public $alias = "geo";
 public $defaultCountry = [];

 public function __construct(){
 global $app;
 $this->defaultCountry = $this->getDefaultCountry();
 $this->setMapVendor();
 }

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

public function autodetectStatus(){
    global $app;

    if($app->settings->active_countries){
        if($app->settings->geo_autodetect){
            return true;
        }
    }   

    return false;           

}

public function countChangeOptionsCity(){

    if($_GET['city_districts'] && $_GET['city_metro']){
        return count($_GET['city_districts']) + count($_GET['city_metro']);
    }elseif($_GET['city_districts']){
        return count($_GET['city_districts']);
    }elseif($_GET['city_metro']){
        return count($_GET['city_metro']);
    }

}

public function getChange(){
    global $app;

    $geo = $app->session->get("geo");

    if($geo){
        return $geo;
    }

    return [];

}

public function getCityData($city_id=0){
    global $app;

    if(!$city_id || !$app->settings->active_countries){
        return [];
    }

    $data = $app->model->geo_cities->cacheKey(["id"=>$city_id])->getRow("id=? and status=? and country_id IN(".implode(",",$app->settings->active_countries).")", [$city_id,1]);
    if($data){
        $data["country"] = $app->model->geo_countries->cacheKey(["id"=>$data["country_id"]])->getRow("id=?", [$data["country_id"]]);
        $data["region"] = $app->model->geo_regions->cacheKey(["id"=>$data["region_id"]])->getRow("id=?", [$data["region_id"]]);
    }

    return arrayToObject($data);

}

public function getCityDataByValue($value=[]){
    global $app;

    if($value){

        $value["country"] = $app->model->geo_countries->cacheKey(["id"=>$value["country_id"]])->getRow("id=?", [$value["country_id"]]);
        $value["region"] = $app->model->geo_regions->cacheKey(["id"=>$value["region_id"]])->getRow("id=?", [$value["region_id"]]);

        return $value;

    }

    return [];

}

public function getCurrentGeoBySeo(){
    global $app;

    if($this->getChange()){
        return (object)["name"=>translateFieldReplace($this->getChange()->data, "name"), "name_declension"=>translateFieldReplace($this->getChange()->data, "declension"), "seo_text"=>translateFieldReplace($this->getChange()->data, "seo_text")];
    }

    return (object)["name"=>translateFieldReplace($this->defaultCountry, "name"), "name_declension"=>translateFieldReplace($this->defaultCountry, "declension"), "seo_text"=>translateFieldReplace($this->defaultCountry, "seo_text")];

}

public function getDefaultCountry(){
    global $app;
    $get = $app->model->geo_countries->find("default_status=? and status=?", [1,1]);
    if(!$get){
        $get = $app->model->geo_countries->find("status=?", [1]);
    }
    return $get;
}

public function getRegionData($region_id=0){
    global $app;

    if(!$app->settings->active_countries){
        return [];
    }

    $data = $app->model->geo_regions->cacheKey(["id"=>$region_id])->getRow("id=? and status=? and country_id IN(".implode(",",$app->settings->active_countries).")", [$region_id,1]);
    if($data){
        $data["country"] = $app->model->geo_countries->cacheKey(["id"=>$data["country_id"]])->getRow("id=?", [$data["country_id"]]);
    }

    return arrayToObject($data);

}

public function getRegionDataByValue($value=[]){
    global $app;

    if($value){

        $value["country"] = $app->model->geo_countries->cacheKey(["id"=>$value["country_id"]])->getRow("id=?", [$value["country_id"]]);

        return $value;

    }

    return [];

}

public function getUrlParamsOptionsCity(){
    global $app;

    $params = [];

    if($_GET["city_districts"]){
        if(is_array($_GET["city_districts"])){
            foreach (array_slice($_GET["city_districts"], 0, 100) as $key => $value) {
                $params["city_districts"][] = $value;
            }
        }
    }

    if($_GET["city_metro"]){
        if(is_array($_GET["city_metro"])){
            foreach (array_slice($_GET["city_metro"], 0, 100) as $key => $value) {
                $params["city_metro"][] = $value;
            }
        }
    }

    return $params ? '?'.http_build_query($params) : '';

}

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

public function locationTypes(){
    return [
        1 => ["name"=>translate("tr_069c9cb17c0aca1e499f3a00fdeb9b3a"), "short"=>translate("tr_1452852c777e5004f6baea097aa1afc3")],
        2 => ["name"=>translate("tr_7a6fedab948a6414349752121e64d6f1"), "short"=>translate("tr_3f353af53544d9b0827e3db52a852746")],
        3 => ["name"=>translate("tr_318c11aeb210540144ad1801fc8af92f"), "short"=>translate("tr_51a5f49dfbd36ccb6229a80e26736046")],
        4 => ["name"=>translate("tr_253d7b9f961a7c579ba940bbbe14805a"), "short"=>translate("tr_d8e1ef7f4ac11071e2b157586b24ba26")],
        5 => ["name"=>translate("tr_2b53cb2ab093f561d482033fe65bf3a0"), "short"=>translate("tr_ba3011963af23090493bea368b366a4a")],
        6 => ["name"=>translate("tr_dcf881fbfc158ca198f7e285b7ce3c75"), "short"=>translate("tr_51a5f49dfbd36ccb6229a80e26736046")],
        7 => ["name"=>translate("tr_3377ec8124fd040d91ed596bad19c09e"), "short"=>translate("tr_fa7adb6a923a3e934db68789b9b4095f")],
    ];
}

public function mapBuildMarkersByAds($data=[]){
    global $app;

    $result = [];

    $result["type"] = "FeatureCollection";

    foreach ($data as $key => $value) {

        $latitude = $value["address_latitude"] ?: $value["geo_latitude"];
        $longitude = $value["address_longitude"] ?: $value["geo_longitude"];         

        if($latitude && $longitude){       

            if($app->settings->integration_map_service == "yandex"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$latitude,$longitude],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "google"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$latitude, $longitude],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "openmapstreet"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$longitude,$latitude],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }

        }
        
    }

    return $result;

}

public function mapBuildMarkersByDelivery($data=[]){
    global $app;

    $result = [];

    $result["type"] = "FeatureCollection";

    foreach ($data as $key => $value) {

        if($value["latitude"] && $value["longitude"]){       

            if($app->settings->integration_map_service == "yandex"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["latitude"],$value["longitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "google"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["latitude"], $value["longitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "openmapstreet"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["longitude"], $value["latitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }

        }
        
    }

    return $result;

}

public function outActiveCountries(){
    global $app;

    $result = '';

    $countries = $app->model->geo_countries->sort("default_status desc, name asc")->getAll("status=?", [1]);

    if($countries){

        foreach ($countries as $key => $value) {

            $image = '';
            $active = '';

            if($this->getChange()->country_id){
                if($this->getChange()->country_id == $value["id"]){
                    $active = 'active';
                }
            }else{
                if($this->defaultCountry){
                    if($this->defaultCountry->id == $value["id"]){
                        $active = 'active';
                    }
                }
            }

            if($app->storage->name($value["image"])->path('images')->exist()){
                $image = '<img src="'.$app->storage->name($value["image"])->path('images')->get().'" />';
            }

            $result .= '<a href="#" data-id="'.$value["id"].'" class="link-geo-country-item '.$active.'" >'.$image.translateFieldReplace($value, "name").'</a>';

        }

    }

    return $result;

}

public function outAdvertisingGeo($geo=[]){
    global $app;

    if($geo){
         foreach (_json_decode($geo) as $purpose => $nested) {
           foreach ($nested as $key => $value) {
             if($purpose == "city"){
                 $geo = $app->model->geo_cities->find("id=?", [$value]);
             }elseif($purpose == "region"){
                 $geo = $app->model->geo_regions->find("id=?", [$value]);
             }elseif($purpose == "country"){
                 $geo = $app->model->geo_countries->find("id=?", [$value]);
             }
             ?>
             <div class="advertising-geo-inputs-item" > <span class="advertising-geo-inputs-item-delete" ><i class="ti ti-trash"></i></span> <input type="hidden" name="geo[<?php echo $purpose; ?>][]" value="<?php echo $geo->id; ?>" /> <?php echo $geo->name; ?> </div>
             <?php
           }
         }
    }        

}

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

public function outFullNameCity($data=[]){

    $type = $this->locationTypes();

    $result = "";

    if($data["location_type_code"]){
        $result .= _strtolower($type[$data["location_type_code"]]["short"]);
    }

    $result .= translateFieldReplace($data, "name");

    if($data["region_name"]){
        $result .= ', '.translateFieldReplace($data, "region_name");
    }

    return $result;
}

public function outMapChangeAddressInAdCreate(){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapChangeAddressScript();
    }

}

public function outMapDeliveryPoints($delivery_id=0, $params=[]){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapDeliveryPoints($delivery_id, $params);
    }

}

public function outMapPointAddressInAdCard($latitude=0, $longitude=0){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapPointAddressScript($latitude, $longitude);
    }

}

public function outMapSearchItems(){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapSearchItemsScript();
    }

}

public function outOptionsCities($city_id=0){
    global $app;

    $result = [];
    $tabs = '';
    $button_clear = '';

    if(!$city_id){
        $city_id = $this->getChange()->city_id ?: 0;
    }

    if($this->countChangeOptionsCity()){
        $button_clear = '<button class="btn-custom button-color-scheme2 mr5 actionClearGeoModal">'.translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5").'</button>';
    }

    $districts = $app->model->geo_cities_districts->sort("name asc")->getAll("city_id=?", [$city_id]);
    $metro = $app->model->geo_cities_metro->sort("name asc")->getAll("city_id=?", [$city_id]);

    if($districts){

        foreach ($districts as $key => $value) {

           $checked = "";
           if(compareValues($_GET['city_districts'], $value["id"])){
                $checked = 'checked=""';
           }

           $result["districts"][] = '
            <div class="form-check">
                <input type="checkbox" name="city_districts[]" class="form-check-input" id="filter-district-'.$value["id"].'" value="'.$value["id"].'" '.$checked.' >
                <label class="form-check-label" for="filter-district-'.$value["id"].'">'.translateFieldReplace($value, "name").'</label>
            </div>
           ';
        }

    }

    if($metro){

        foreach ($metro as $key => $value) {

           $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);

           if($station){

               $checked = "";
               if(compareValues($_GET['city_metro'], $value["id"])){
                    $checked = 'checked=""';
               }

               $result["metro"][] = '
                <div class="form-check">
                    <input type="checkbox" name="city_metro[]" class="form-check-input" id="filter-metro-'.$value["id"].'" value="'.$value["id"].'" '.$checked.' >
                    <label class="form-check-label" for="filter-metro-'.$value["id"].'">'.translateFieldReplace($value, "name").' <i class="modal-metro-station-color" style="background-color:'.$station->color.';" ></i> '.translateFieldReplace($station, "name").'</label>
                </div>
               ';

           }

        }

    }

    if($result["districts"] && $result["metro"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_73d7050e5b86bed85fdc6182c27b7d59").'</div>';
        $tabs .= '<div data-tab="2" >'.translate("tr_bf81bef60d4246393b8391e940a00e3d").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["districts"]).'
        </div>
        <div class="modal-geo-tab-2 modal-geo-tab-content" >
           '.implode("", $result["metro"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>
        ';

    }elseif($result["districts"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_73d7050e5b86bed85fdc6182c27b7d59").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["districts"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>            
        ';

    }elseif($result["metro"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_bf81bef60d4246393b8391e940a00e3d").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["metro"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>
        ';

    }


}

public function outOptionsFavoritesCities($country_id=0){
    global $app;

    if($country_id){

        if($this->getChange()->country_id == $country_id){

            if(!$this->getChange()->city_id && !$this->getChange()->region_id){

                return '
                    <div class="modal-geo-container-favorites mt-3" >

                      <div class="row" >
                        '.$this->outFavoritesCities($country_id).'
                      </div>

                    </div>
                ';

            }elseif($this->getChange()->city_id){

                return $this->outOptionsCities();

            }

        }else{

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities($country_id).'
                  </div>

                </div>
            ';

        }

    }else{

        if(!$this->getChange()->city_id && !$this->getChange()->region_id){

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities().'
                  </div>

                </div>
            ';

        }elseif($this->getChange()->city_id){

            $options = $this->outOptionsCities();

            if($options){
                return $options;
            }

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities($country_id).'
                  </div>

                </div>
            ';

        }

    }

}

public function outRegionsOptions($country_id=0, $region_id=0){
    global $app;

    $getRegions = $app->model->geo_regions->sort("name asc")->getAll("country_id=?", [$country_id]);

    if($getRegions){
        foreach ($getRegions as $key => $value) {
            if($region_id){
                if($value["id"] == $region_id){
                    echo '<option value="'.$value["id"].'" selected="" >'.translateFieldReplace($value, "name").'</option>';
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateFieldReplace($value, "name").'</option>';
                }
            }else{
                echo '<option value="'.$value["id"].'" >'.translateFieldReplace($value, "name").'</option>';
            }
        }
    }

}

public function outSystemStationCityMetro($item_id){
    global $app;

    $result = $app->model->geo_cities_metro->getAll("parent_id=?", [$item_id]);
    if($result){
        foreach ($result as $key => $value) {
            echo '<div class="country-city-metro-item mb-2" ><div class="input-group"><input type="text" class="form-control" name="stations[update]['.$value["id"].']" value="'.translateFieldReplace($value, "name").'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemCityMetro"><i class="ti ti-trash"></i></span></div></div>';
        }
    }

}

public function replaceAliases($data=[]){
    global $app;

    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    $aliases = [];

    if($app->router->beforeRouteName == "search-by-map" || $app->router->currentRoute->name == "search-by-map"){

        if($data){

            if($this->statusMultiCountries()){
                $aliases[] = $data["country"]["alias"];
            }

            if($data["region"]){
                $aliases[] = $data["region"]["alias"];
            }

            $aliases[] = $data["alias"];

            if($geo){

                if($request){
                    return outLink('map/' . trim(str_replace($geo->alias, implode("/", $aliases), $request->uri), "/"));
                }else{
                    return outLink('map/' . implode("/", $aliases));
                }

            }else{

                if($request && $request->uri != "all"){
                    $aliases[] = $request->uri;
                }

                return outLink('map/' . implode("/", $aliases));

            }

        }

    }else{

        if($data){

            if($this->statusMultiCountries()){
                $aliases[] = $data["country"]["alias"];
            }

            if($data["region"]){
                $aliases[] = $data["region"]["alias"];
            }

            $aliases[] = $data["alias"];

            if($geo){

                if($request){
                    return outLink(trim(str_replace($geo->alias, implode("/", $aliases), $request->uri), "/"));
                }else{
                    return outLink(implode("/", $aliases));
                }

            }else{

                if($request && $request->uri != "all"){
                    $aliases[] = $request->uri;
                }

                return outLink(implode("/", $aliases));

            }

        }

    }

}

public function replaceAllCities(){
    global $app;

    $aliases = [];
    
    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    if($app->router->currentRoute->name == "search-by-map" || $app->router->beforeRouteName == "search-by-map"){
        $aliases[] = "map";
    }

    if($geo){

        if($request){
            $result = trim(str_replace($geo->alias, "", $request->uri), "/");
            if($result){
                return outLink(implode("/", $aliases) . '/' . $result);
            }else{
                return outLink(implode("/", $aliases) . '/all');
            }
        }else{
            return outLink(implode("/", $aliases) . '/all');
        }

    }else{

        if($request){
            return outLink(implode("/", $aliases) . '/' . $request->uri);
        }else{
            return outLink(implode("/", $aliases) . '/all');
        }

    }

}

public function replaceAllCitiesByCountry($alias=null){
    global $app;

    if($app->router->currentRoute->name == "search-by-map" || $app->router->beforeRouteName == "search-by-map"){
        return outLink('map/' . $alias);
    }

    return outLink($alias);

}

public function searchAddress($query=null, $city_id=0){
    global $app;

    $items = "";
    $result = [];

    if(_mb_strlen($query) < 2){
        return (object)["items"=>$items];
    }

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        $result = $vendor->searchAddress($query,$city_id);
        if($result){
            foreach ($result as $key => $value) {
                $items .= '<span class="geo-city-item" data-latitude="'.$value["lat"].'" data-longitude="'.$value["lon"].'" >'.$value["address"].'</span>';
            }
        }
    }

    return (object)["items"=>$items];

}

public function searchAddressByCoordinates($latitude = 0, $longitude = 0){
    global $app;

    $result = '';

    if($latitude && $longitude){

        if($app->settings->integration_map_service){
            $vendor = $app->addons->map($app->settings->integration_map_service);
            $result = $vendor->searchAddressByCoordinates($latitude, $longitude);
        }

    }

    return $result;

}

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

public function setChange($id=0, $purpose=null){
    global $app;

    if($purpose == "city"){

        $data = $this->getCityData($id);

        if($data){

            if($this->statusMultiCountries()){

                if($data->region){
                    $alias = $data->country->alias . '/' . $data->region->alias . '/' . $data->alias;
                }else{
                    $alias = $data->country->alias . '/' . $data->alias;
                }

            }else{

                if($data->region){
                    $alias = $data->region->alias . '/' . $data->alias;
                }else{
                    $alias = $data->alias;
                }

            }

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"city", "alias"=>$alias, "country_id"=>$data->country->id, "region_id"=>$data->region->id, "city_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "declension"=>$data->declension, "latitude"=>$data->latitude?:null, "longitude"=>$data->longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "region"){

        $data = $this->getRegionData($id);

        if($data){

            if($this->statusMultiCountries()){

                $alias = $data->country->alias . '/' . $data->alias;

            }else{

                $alias = $data->alias;

            }

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"region", "alias"=>$alias, "country_id"=>$data->country->id, "region_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "latitude"=>$data->capital_latitude?:null, "longitude"=>$data->capital_longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "country"){

        $data = $app->model->geo_countries->find("id=?", [$id]);

        if($data){

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"country", "alias"=>$data->alias, "country_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "latitude"=>$data->capital_latitude?:null, "longitude"=>$data->capital_longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "all"){
        $app->session->delete("geo");
        _setcookie(["key"=>"geo", "value"=>"","lifetime"=>time()-3600]);
    }else{
        $app->session->delete("geo");
        _setcookie(["key"=>"geo", "value"=>"","lifetime"=>time()-3600]);
    }

    return $app->session->get("geo") ?: [];

}

public function setMapVendor(){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->setMapVendor();
    }
    
}

public function setUserChange(){
    global $app;

    if(!$this->getChange()){

        if(_getcookie("geo")){

            $params = _json_decode(_getcookie("geo"));

            if($params){

                if($params["purpose"] == "country"){
                    if($this->statusMultiCountries()){
                        $this->setChange($params["id"], $params["purpose"]);
                    }
                }else{
                    $this->setChange($params["id"], $params["purpose"]);
                }

            }

        }
        
    }

}

public function statusMultiCountries(){
    global $app;

    if($app->settings->active_countries){
        if(count($app->settings->active_countries) > 1){
            return true;
        }
    }

    return false;

}

public function updateActiveCountries(){
    global $app;
    $ids = [];
    $getActiveCountries = $app->model->geo_countries->getAll("status=?", [1]);
    if($getActiveCountries){
        foreach ($getActiveCountries as $key => $value) {
            $ids[] = $value["id"];
        }
    }
    $app->model->settings->update($ids ? _json_encode($ids) : null, "active_countries");
}



}