public function send()
{   

    $params["from_user_id"] = $this->user->data->id;
    $params["text"] = $_POST['text'];
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    if($this->system->checkingBadRequests("chat",$this->user->data->id)){
        return json_answer(["status"=>false]);
    }

    if($_POST['attach_files']){
        $params["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
    }

    $id = $this->component->chat->sendMessage($params);

    return json_answer(["id"=>$id]); 

}