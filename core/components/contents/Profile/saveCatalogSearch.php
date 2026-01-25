public function saveCatalogSearch($params=[], $user_id=0){   
    global $app;

    if($params){
        if(!is_array($params)){
            $params = [];
        }
    }

    $request = $app->session->get("request-catalog");
    $geo = $app->session->get("geo");
    $link = trim(str_replace("&amp;", "&", urldecode($params["link"])), "/");

    if($app->config->app->prefix_path){

        $uri_explode = explode("/", $link);

        if($uri_explode[0] == $app->config->app->prefix_path){
            unset($uri_explode[0]);
        }

        $link = implode("/", $uri_explode);

    }

    $token = md5($link ?: null);

    $get = $app->model->users_searches->find("user_id=? and token=?", [$user_id, $token]);

    if($get){
        $app->model->users_searches->delete("id=?", [$get->id]);
        return ["answer"=>translate("tr_7f28e84837e808158a5d73734f7e7d7a"), "label"=>translate("tr_852be42059679d4e4fef58aad5f3fa2f")];
    }else{
        $app->model->users_searches->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "params"=>$params ? _json_encode($params) : null, "category_id"=>$request->category_id?:0, "city_id"=>$geo->city_id?:0, "region_id"=>$geo->region_id?:0, "country_id"=>$geo->country_id?:0,"token"=>$token, "link"=>$link ?: null]);
        return ["answer"=>translate("tr_35e32673f23298102ec36862d57f0154"), "label"=>translate("tr_f6acf24dca325b44869ec3fe34ef5083")];
    }

}