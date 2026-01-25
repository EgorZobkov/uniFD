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