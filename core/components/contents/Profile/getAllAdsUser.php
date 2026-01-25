public function getAllAdsUser($user_id=0, $status=null){   
    global $app;

    $content = '';
    $status_query = null;

    if($status == "active"){
        $status_query = '1';
    }elseif($status == "sold"){
        $status_query = '7';
    }elseif($status == "moderation"){
        $status_query = '0';
    }elseif($status == "waiting_payment"){
        $status_query = '5';
    }elseif($status == "archive"){
        $status_query = '2,3,4,8';
    }

    if(isset($status_query)){
        $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and status IN(".$status_query.")", [$user_id]);
    }else{
        $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=?", [$user_id]);
    }

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-list.tpl');

        }
    }

    return $content;
    
}