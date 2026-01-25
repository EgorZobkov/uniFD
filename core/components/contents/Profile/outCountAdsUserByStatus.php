public function outCountAdsUserByStatus($status=null, $user_id=0){
    global $app;

    if(!$user_id){
        $user_id = $app->user->data->id;
    }

    if($status == "active"){
        $status = '1';
    }elseif($status == "sold"){
        $status = '7';
    }elseif($status == "moderation"){
        $status = '0';
    }elseif($status == "waiting_payment"){
        $status = '5';
    }elseif($status == "archive"){
        $status = '2,3,4,8';
    }

    if(isset($status)){
        $count = $app->model->ads_data->count("user_id=? and status IN(".$status.")", [$user_id]);
    }else{
        $count = $app->model->ads_data->count("user_id=?", [$user_id]);
    }

    return $count ?: '';

}