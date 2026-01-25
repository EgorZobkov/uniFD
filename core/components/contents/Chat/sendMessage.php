public function sendMessage($params=[]){
    global $app;

    $date = $app->datetime->getDate();
    $hash_id = md5(time().uniqid());
    $message_id = 0;

    if(!$params["action"]){
        if(trim($params["text"])){
            if(_mb_strlen($params["text"]) > 5000){
                $params["text"] = trimStr($params["text"], 5000);
            }
        }else{
            if(!$params["attach_files"]){
                return;
            }
        }
    }

    if($params["token"]){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);

        if($getDialogue){

            $message_id = $this->createDialogueAndMessage(["ad_id"=>$getDialogue->ad_id, "from_user_id"=>$getDialogue->user_id, "whom_user_id"=>$getDialogue->from_user_id, "text"=>$params["text"], "channel_id"=>$getDialogue->channel_id, "attach_files"=>$params["attach_files"], "responder_id"=>$getDialogue->responder_id, "action"=>$params["action"]]);

        }else{

            if($params["action"]){
                $message_id = $this->createDialogueAndMessage(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$params["text"], "channel_id"=>$params["channel_id"]?:0, "attach_files"=>$params["attach_files"], "responder_id"=>$params["responder_id"]?:0, "action"=>$params["action"]]);
            }

        }

    }elseif($params["channel_id"]){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$params["channel_id"], 1]);

        if($getChannel){

            if($getChannel->type == "support"){

                $message_id = $this->createDialogueAndMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$params["text"], "channel_id"=>$params["channel_id"], "attach_files"=>$params["attach_files"], "responder_id"=>$params["responder_id"]]);
           
            }else{

                if($app->component->profile->isBlacklistСross($params["from_user_id"], 0, $params["channel_id"])){
                    return;
                }

                $message_id = $app->model->chat_messages->insert(["user_id"=>0,"from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>0,"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$this->buildToken(["channel_id"=>$params["channel_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>0])]);

            }

        }

    }

    return $message_id;

}