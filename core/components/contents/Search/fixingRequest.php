public function fixingRequest($query=null, $link=null, $user_id=0){
    global $app;

    if(!$query) return;

    $geo = $app->session->get("geo");
    $session_id = $app->session->get("user-session-id");

    if($app->model->search_requests->count("(ip=? or session_id=?) and date(time_create)=?", [getIp(), $session_id, $app->datetime->format("Y-m-d")->getDate()]) >= 50){
        return;
    }

    if(!$_GET['search']){

        if(strpos($link, "?") !== false){

            $split = explode("?", $link);

            parse_str(str_replace("amp;", "", urldecode($split[1])), $url_params);

            if($url_params["s_marker"] == "filter"){
                if($geo){
                    $link = trim(str_replace($geo->alias, "", $link), "/");
                }
            }

        }

    }else{
        $link = "";
    }

    $app->model->search_requests->delete("(ip=? or session_id=?) and name=?", [getIp(), $session_id, $query]);
    $app->model->search_requests->insert(["name"=>$query, "time_create"=>$app->datetime->getDate(), "ip"=>getIp(), "session_id"=>$session_id ?: null, "user_id"=>$user_id?:0, "link"=>$link ? clearHostInURI($link) : null, "keyword_id"=>$url_params["keyword_id"]?:0, "marker"=>$url_params["s_marker"]?:null]);

}