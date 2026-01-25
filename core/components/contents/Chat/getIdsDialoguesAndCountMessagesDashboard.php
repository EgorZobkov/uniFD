public function getIdsDialoguesAndCountMessagesDashboard(){
    global $app;

    $result = [];

    $data = $app->model->chat_messages->getAll("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,1]);

    if($data){
        foreach ($data as $key => $value) {
            $result["support"][$value["token"]] = ["token"=>$value["token"], "dialogue_id"=>$value["dialogue_id"], "count"=>$app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=? and token=?", [0,0,0,0,1,$value["token"]])];
        }
    }

    $data = $app->model->chat_messages->getAll("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id!=? and channel_id!=?", [0,0,0,0,1,0]);

    if($data){
        foreach ($data as $key => $value) {
            $result["channel"][$value["channel_id"]] = ["channel_id"=>$value["channel_id"], "count"=>$app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,$value["channel_id"]])];
        }
    }

    return $result;

}