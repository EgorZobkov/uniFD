public function addAuthSession($params=[]){
    global $app;
    $app->model->auth_sessions->insert(["user_id"=>$params["user_id"], "user_agent"=>_json_encode(getUserAgent()), "ip"=>getIp(), "time_create"=>$app->datetime->getDate(), "geo"=>null, "device_model"=>$params["device_model"] ?: null]);
}