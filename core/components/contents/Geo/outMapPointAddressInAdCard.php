public function outMapPointAddressInAdCard($latitude=0, $longitude=0){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapPointAddressScript($latitude, $longitude);
    }

}