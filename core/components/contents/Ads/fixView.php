public function fixView($ad_id=0, $user_id=0){
    global $app;

    if($user_id){

        $get = $app->model->ads_views->find("user_id=? and ad_id=?", [$user_id, $ad_id]);
        
        if(!$get){
            $app->model->ads_views->insert(["ad_id"=>$ad_id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif(getIp()){

        if(isBot(getUserAgent())){
            return;
        }

        $get = $app->model->ads_views->find("ip=? and ad_id=? and date(time_create)=?", [getIp(), $ad_id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$get){
            $app->model->ads_views->insert(["ad_id"=>$ad_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}