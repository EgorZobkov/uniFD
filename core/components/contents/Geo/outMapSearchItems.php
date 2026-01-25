public function outMapSearchItems(){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapSearchItemsScript();
    }

}