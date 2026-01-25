public function buildParams($params=[]){
    global $app;

    if($params["ad_id"]){
        $build["ad_id"] = $params["ad_id"];
    }

    if($params["channel_id"]){
        $build["channel_id"] = $params["channel_id"];
    }

    if($params["whom_user_id"]){
        $build["whom_user_id"] = $params["whom_user_id"];
    }

    $build["token"] = md5(implode(".", $build).'.'.$app->config->app->signature_hash);

    return urlencode(_json_encode($build));

}