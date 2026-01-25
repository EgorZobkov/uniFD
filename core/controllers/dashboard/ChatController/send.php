public function send()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $params["from_user_id"] = 0;
    $params["text"] = $_POST['text'];
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    if($_POST['attach_files']){
        $params["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
    }

    $id = $this->component->chat->sendMessage($params);

    return json_answer(["id"=>$id]);

}