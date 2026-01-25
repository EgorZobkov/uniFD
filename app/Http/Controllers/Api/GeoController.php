<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class GeoController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function location(){ 

        $city = [];
        $latitude = $_GET['lat'];
        $longitude = $_GET['lon'];

        $radius = 0.7;
        $lat_range = $radius/69.172;  
        $lon_range = abs($radius/(cos($latitude) * 69.172));  
        $min_lat = number_format($latitude - $lat_range, "4", ".", "");  
        $max_lat = number_format($latitude + $lat_range, "4", ".", "");  
        $min_lon = number_format($longitude - $lon_range, "4", ".", "");  
        $max_lon = number_format($longitude + $lon_range, "4", ".", "");  

        if($latitude && $longitude){

            $city = $this->model->geo_cities->find("(`latitude` BETWEEN ? AND ?) AND (`longitude` BETWEEN ? AND ?) and status=?", [$min_lat,$max_lat,$min_lon,$max_lon,1]);           

        }

        if($city){
            return json_answer(["city_name"=>translateFieldReplace($city, "name", $_REQUEST["lang_iso"]), "city_id"=>$city->id, "lat"=>$latitude,"lon"=>$longitude, "declension"=>translateFieldReplace($city, "declension", $_REQUEST["lang_iso"]) ?: null, "status"=>true]);
        }else{
            return json_answer(["status"=>false]);
        }

    }

    public function searchGeoCombined(){ 

        if(!$_GET['only_city']){
            $data = $this->api->searchGeoCombined($_GET['query'], $_GET['country_id']);
        }else{
            $data = $this->api->searchCity($_GET['query'], $_GET['country_id']);
        }

        return json_answer(["data"=>$data]);

    }

    public function decodingAddressByCoordinates(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $vendor = $this->addons->map($this->settings->integration_map_service);
        $result = $vendor->searchAddressByCoordinates($_GET['lat'], $_GET['lon']);  
        
        if($result){
            return json_answer(["data"=>$result, "status"=>true]);
        }else{
            return json_answer(["status"=>false]);
        }      

    }

    public function searchAddress(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $items = [];

        $vendor = $this->addons->map($this->settings->integration_map_service);
        $result = $vendor->searchAddress($_GET['query'], $_GET['city_id']);  
        
        if($result){
            foreach ($result as $key => $value) {
                $items[] = ["lat"=>$value["lat"], "lon"=>$value["lon"], "address"=>$value["address"]];
            }
        }

        return json_answer(["data"=>$items]);      

    }

    public function getCountriesAndDefaultCities(){ 

        $countries = [];
        $cities = [];

        $getCountries = $this->model->geo_countries->getAll("status=?", [1]);

        if($getCountries){

            foreach ($getCountries as $key => $value) {

                $cities = [];

                $getCities = $this->model->geo_cities->getAll("favorite=? and status=? and country_id=?", [1,1,$value["id"]]);

                if($getCities){

                    foreach ($getCities as $city_value) {
                        $cities[] = ["name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "geo_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($city_value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "region_name"=>translateFieldReplace($city_value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($city_value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$city_value["id"], "region_id"=>$city_value["region_id"], "country_id"=>$city_value["country_id"], "lat"=>$city_value["latitude"] ?: null, "lon"=>$city_value["longitude"] ?: null];
                    }

                }else{

                    $getCities = $this->model->geo_cities->getAll("status=? and country_id=? limit 30", [1,$value["id"]]);

                    if($getCities){

                        foreach ($getCities as $city_value) {
                            $cities[] = ["name"=>$city_value["name"], "geo_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($city_value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "region_name"=>translateFieldReplace($city_value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($city_value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$city_value["id"], "region_id"=>$city_value["region_id"], "country_id"=>$city_value["country_id"], "lat"=>$city_value["latitude"] ?: null, "lon"=>$city_value["longitude"] ?: null];
                        }                        

                    }

                }

                $countries[] = ["id"=>$value["id"], "name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "cities"=>$cities ?: null];

            }

        }


        $getDefaultCities = $this->model->geo_cities->getAll("favorite=? and status=?", [1,1]);

        if($getDefaultCities){

            foreach ($getDefaultCities as $key => $city_value) {
                $cities_default[] = ["name"=>$city_value["name"], "geo_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($city_value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>translateFieldReplace($city_value, "name", $_REQUEST["lang_iso"]), "region_name"=>translateFieldReplace($city_value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($city_value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$city_value["id"], "region_id"=>$city_value["region_id"], "country_id"=>$city_value["country_id"], "lat"=>$city_value["latitude"] ?: null, "lon"=>$city_value["longitude"] ?: null];
            }

        }

        return json_answer(["countries"=>$countries, "cities_default"=>$cities_default ?: null]);

    }

}