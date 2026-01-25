public function isSavedSearch(){
    global $app;

    $params = [];

    $request_params = trim(getAllRequestURI(), "/");

    if($request_params){
        parse_str($request_params, $params);
    }

    $request = $app->session->get("request-catalog");
    $geo = $app->session->get("geo");

    $token = md5(urldecode($request_params));

    $check = $app->model->users_searches->find("user_id=? and token=?", [$app->user->data->id, $token]);
    if($check){
        return true;
    }
    return false;
}