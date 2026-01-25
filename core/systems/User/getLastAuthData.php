public function getLastAuthData($user_id=0){
    global $app;
    $data = $app->model->auth->find("user_id=? order by id desc", [$user_id]);
    if($data){
        $data->geo = $data->geo ? (object)_json_decode($data->geo) : [];
    }
    return $data;
}