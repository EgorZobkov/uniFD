public function addAuth($params=[]){
    global $app;
    $app->model->auth->insert(["user_id"=>$params["user_id"], "token"=>$params["token"], "time_expiration"=>$app->datetime->addDay(30)->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "geo"=>null, "entry_point"=>$params["entry_point"], "device_model"=>$params["device_model"] ?: null]);
}