<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class GeoController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function change()
{   

    $result = $this->component->geo->outOptionsCities($_POST['id']);

    if($result){

        return json_answer(["content"=>$result]);

    }

    $this->component->geo->setChange($_POST['id'], $_POST['purpose']);
    
    return json_answer(["content"=>""]);

}

public function changeCountry()
{   

    $result = $this->component->geo->outOptionsFavoritesCities($_POST['id']);

    return json_answer(["content"=>$result]);

}

public function changeOptions()
{   

    $params = [];

    $url = trim($_POST['geo_alias'], "/");

    if($_POST["city_districts"]){
        $params["city_districts"] = $_POST["city_districts"];
    }

    if($_POST["city_metro"]){
        $params["city_metro"] = $_POST["city_metro"];
    }

    if($_POST["sort"]){
        $params["sort"] = $_POST["sort"];
    }

    if($url){

        $url = parse_url($url, PHP_URL_PATH);

        $last = end(explode("/", $url));

        $filter_link = $this->model->ads_filters_links->find('alias=?', [$last]);

        if(!$filter_link){

            if($_POST["filter"]){
                $params["filter"] = $_POST["filter"];
            }

        }

    }

    if($url){

        if($params){
            return json_answer(["link"=>$url.'?'.http_build_query($params)]);       
        }else{
            return json_answer(["link"=>$url]);
        }     

    }

    return json_answer(["link"=>getHost().'/all']);
    
}

public function clearOptions()
{   

    $url = trim(urldecode($_POST['url']), "/");

    if($url){

        if(strpos($url, "?") !== false){
            $url = explode("?", $url);
            parse_str($url[1], $params);
            if($params["city_districts"]) unset($params["city_districts"]);
            if($params["city_metro"]) unset($params["city_metro"]);   
            if($params){ 
                return json_answer(["link"=>getHost().'/'.$url[0].'?'.http_build_query($params)]);  
            }else{
                return json_answer(["link"=>getHost().'/'.$url[0]]);
            }        
        }

    }

    return json_answer(["link"=>$url]);

}

public function coordinatesDetect()
{   

    if($this->session->get("geo-autodetect") || $this->component->geo->getChange() || !$this->settings->geo_autodetect){
       return false;
    }

    $latitude = $_POST['lat'];
    $longitude = $_POST['lon'];

    $radius = 0.7;
    $lat_range = $radius/69.172;  
    $lon_range = abs($radius/(cos($latitude) * 69.172));  
    $min_lat = number_format($latitude - $lat_range, "4", ".", "");  
    $max_lat = number_format($latitude + $lat_range, "4", ".", "");  
    $min_lon = number_format($longitude - $lon_range, "4", ".", "");  
    $max_lon = number_format($longitude + $lon_range, "4", ".", "");  

    if($latitude && $longitude){

        $this->session->set("geo-autodetect", [$latitude,$longitude]);

        $city = $this->model->geo_cities->find("(`latitude` BETWEEN ? AND ?) AND (`longitude` BETWEEN ? AND ?) and status=?", [$min_lat,$max_lat,$min_lon,$max_lon,1]);

        $this->component->geo->setChange($city->id, "city");

        if($city){
            return json_answer(["status"=>true]);
        }            

    }

    return json_answer(["status"=>false]);

}

public function searchAddress()
{   

    $result = $this->component->geo->searchAddress($_POST['query'], $_POST['city_id']);

    return json_answer(["answer"=>$result->items]);

}

public function searchCity()
{   

    $result = $this->component->geo->searchCity($_POST['query']);

    return json_answer(["answer"=>$result->items]);

}

public function searchCombined()
{   

    return $this->component->geo->searchCombined($_POST['query'], $_POST['country_id']);

}



 }