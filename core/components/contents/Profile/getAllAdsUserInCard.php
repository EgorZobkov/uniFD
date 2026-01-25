public function getAllAdsUserInCard($user_id=0, $status=null){   
    global $app;

    $content = '';
    $status_query = null;

    if($status == "active"){
        $status_query = '1';
    }elseif($status == "sold"){
        $status_query = '7';
    }else{
        $status_query = '1';
    }

    $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and status IN(".$status_query.")", [$user_id]);

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid.tpl');

        }
    }

    return $content;
    
}