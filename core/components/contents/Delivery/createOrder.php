public function createOrder($data=[]){
    global $app;

    $ad = $app->component->ads->getAd($data->item->item_id);

    if($ad){

        if($data->delivery_service){
            $params = (object)["data"=>$data, "ad"=>$ad];
            return $app->addons->delivery($data->delivery_service->alias)->createOrder($params);
        }

    }

    return [];

}