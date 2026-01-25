public function addWaiting(){
    global $app;

    if(isset($this->code)){

        $app->model->users_waiting_notifications->insert(["time_create"=>$app->datetime->getDate(), "params"=>$this->params ? _json_encode($this->params) : null, "action_code"=>$this->code, "user_id"=>$this->userId?:0]);

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

}