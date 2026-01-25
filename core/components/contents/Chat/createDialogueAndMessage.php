public function createDialogueAndMessage($params=[], $event=true){
    global $app;

    if(!$params["from_user_id"] && !$params["whom_user_id"]){
        return;
    }

    if($params["ad_id"]){
        if(!$app->model->ads_data->find("id=?", [$params["ad_id"]])){
            return;
        }
    }

    if($app->component->profile->isBlacklistСross($params["whom_user_id"], $params["from_user_id"], $params["channel_id"])){
        return;
    }

    $date = $app->datetime->getDate();

    $dialogues = $this->createDialogue(["ad_id"=>(int)$params["ad_id"], "from_user_id"=>(int)$params["from_user_id"], "whom_user_id"=>(int)$params["whom_user_id"], "channel_id"=>(int)$params["channel_id"], "responder_id"=>(int)$params["responder_id"], "action"=>$params["action"]]);

    if(!$params["action"] && !$params["responder_id"]){
        $insert_id = $app->model->chat_messages->insert(["user_id"=>(int)$params["from_user_id"], "from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>(int)$params["whom_user_id"],"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"ad_id"=>(int)$params["ad_id"],"dialogue_id"=>$dialogues->from_dialogue_id,"hash_id"=>$dialogues->hash_id,"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$dialogues->from_token]);
    }

    $app->model->chat_messages->insert(["user_id"=>(int)$params["whom_user_id"], "from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>(int)$params["whom_user_id"],"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"ad_id"=>(int)$params["ad_id"],"dialogue_id"=>$dialogues->whom_dialogue_id,"hash_id"=>$dialogues->hash_id, "action"=>$params["action"],"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$dialogues->whom_token, "parent_message_id"=>$insert_id?:0]);

    if($event){
        $app->event->sendMessageChat($params);
    }

    return $insert_id;

}