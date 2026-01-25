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