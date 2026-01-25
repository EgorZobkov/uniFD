public function sendAction($action=null, $params=[], $event=true){
    global $app;

    $getAction = $app->model->chat_automessages->find("action=?",[$action]);

    if(!$getAction){
        return;
    }

    $text = translateField($getAction->text) ?: $this->getActionCode($action)->default_text;

    if($action == "user_asks_review"){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [$params["from_user_id"],$params["dialogue_id"]]);

        if($getDialogue){

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$getDialogue->user_id,$getDialogue->from_user_id,$getDialogue->ad_id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"],"token"=>$getDialogue->token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "new_review"){

        $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "ad_id"=>$params["ad_id"]]);

        $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "ad_id"=>$params["ad_id"], "token"=>$token, "action"=>$action, "text"=>$text]);

    }elseif($action == "add_to_favorite"){

        $ad = $app->component->ads->getAd($params["ad_id"]);

        if($ad && !$ad->delete){

            if(!$ad->user->notifications['add_to_favorite']){
                return;
            }

            $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id]);

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$ad->user_id,$ad->id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id, "token"=>$token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "view_ad_contacts"){

        $ad = $app->component->ads->getAd($params["ad_id"]);

        if($ad && !$ad->delete){

            if(!$ad->user->notifications['view_ad_contacts']){
                return;
            }

            $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id]);

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$ad->user_id,$ad->id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id, "token"=>$token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "first_message_support"){

        if($params["whom_user_id"] == 0){
            $check = $app->model->chat_messages->find("user_id=? and from_user_id=?", [$params["from_user_id"], 0]);
            if(!$check){
                $this->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$params["from_user_id"], "text"=>$text, "channel_id"=>1, "attach_files"=>null, "action"=>$action], $event);
            }
        }

    }else{

        if($params["from_user_id"]){
            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$params["whom_user_id"],$params["ad_id"]?:0,$action]);
            if(!$check){
                $this->createDialogueAndMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$text, "attach_files"=>null, "ad_id"=>$params["ad_id"]?:0, "action"=>$action]);
            }
        }else{
            $this->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$params["whom_user_id"], "text"=>$text, "channel_id"=>1, "attach_files"=>null, "action"=>$action], $event);
        }

    }

}