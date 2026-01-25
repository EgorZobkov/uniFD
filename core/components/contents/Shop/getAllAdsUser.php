public function getAllAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc")->getAll("user_id=? and status=?", [$user_id, 1]);
    if($getAds){

        if(count($getAds) > 8){
            shuffle($getAds);
        }

        foreach (array_slice($getAds, 0, 8) as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid.tpl');

        }

    }

    return $content;
    
}