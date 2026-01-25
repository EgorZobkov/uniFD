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