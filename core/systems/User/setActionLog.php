public function setActionLog($action_id=null, $params=[]){
    global $app;
    if(isset($action_id)){
        $app->model->users_logs->insert(["user_id"=>$this->data->id, "time_create"=>$app->datetime->getDate(), "action_id"=>$action_id, "body"=>encrypt(_json_encode($params))]);
    }
}