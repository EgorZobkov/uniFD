public function outMapDeliveryPoints($delivery_id=0, $params=[]){
    global $app;

    if($app->settings->integration_map_service){
        $vendor = $app->addons->map($app->settings->integration_map_service);
        return $vendor->outMapDeliveryPoints($delivery_id, $params);
    }

}