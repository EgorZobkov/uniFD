public function fixTraffic(){
    global $app;

    if($app->config->app->prefix_path){

        $uri_explode = explode("/", trim(getAllRequestURI(), "/"));

        if($uri_explode[0] == $app->config->app->prefix_path){
            unset($uri_explode[0]);
        }

        $uri = implode("/", $uri_explode);

    }else{

        $uri = getAllRequestURI();
        
    }

    if($uri){
        $extension = getInfoFile($uri)->extension;
        if($extension){
            return;
        }
    }

    if(isBot(getUserAgent())){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    if($session_id){

        if($app->model->traffic_realtime->find("session_id=?", [$session_id])){
            $app->model->traffic_realtime->update(["uri"=>$uri?:null, "time_update"=>$app->datetime->getDate()], ["session_id=?", [$session_id]]);
        }else{
            $app->model->traffic_realtime->insert(["uri"=>$uri?:null, "session_id"=>$session_id, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "referer"=>$_SERVER['HTTP_REFERER']?:null]);
        }

        if($app->settings->system_report_status){
            if(!$app->model->traffic_report->find("session_id=?", [$session_id])){
                $app->model->traffic_report->insert(["time_create"=>$app->datetime->getDate(), "session_id"=>$session_id]);
            }
        }

    }

}