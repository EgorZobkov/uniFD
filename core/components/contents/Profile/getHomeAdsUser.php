public function getHomeAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc limit 4")->getAll("user_id=?", [$user_id]);
    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/home-profile-grid.tpl');

        }
    }

    return $content;
    
}