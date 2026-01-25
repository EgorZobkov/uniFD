public function getRenewalAdsUser($user_id=0){   
    global $app;

    $content = '';
    
    $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and auto_renewal_status=?", [$user_id, 1]);

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-ads-renewal-list.tpl');

        }
    }

    return $content;
    
}