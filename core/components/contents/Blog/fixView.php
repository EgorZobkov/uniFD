public function fixView($post_id=0, $user_id=0, $ip=null){
    global $app;

    if($user_id){

        $get = $app->model->blog_posts_views->find("user_id=? and post_id=?", [$user_id, $post_id]);
        
        if(!$get){
            $app->model->blog_posts_views->insert(["post_id"=>$post_id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif($ip){

        if(isBot(getUserAgent())){
            return;
        }

        $get = $app->model->blog_posts_views->find("ip=? and post_id=? and date(time_create)=?", [$ip, $post_id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$get){
            $app->model->blog_posts_views->insert(["post_id"=>$post_id, "ip"=>$ip, "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}