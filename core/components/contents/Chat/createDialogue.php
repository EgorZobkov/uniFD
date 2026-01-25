public function createDialogue($params=[], $only_my_dialog=false){
    global $app;

    $date = $app->datetime->getDate();
    $from_dialogue_id = 0;
    $whom_dialogue_id = 0;
    $from_token = '';
    $whom_token = '';

    $hash_id = md5(time().uniqid());

    if($params["channel_id"]){

        if(!$params["action"] && !$params["responder_id"]){

            $from_token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "channel_id"=>$params["channel_id"]]);

            $getFromDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$from_token]);

            if(!$getFromDialogue){
                $from_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["from_user_id"], "from_user_id"=>$params["whom_user_id"],"time_create"=>$date,"time_update"=>$date,"channel_id"=>(int)$params["channel_id"],"hash_id"=>$hash_id, "token"=>$from_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getFromDialogue->id);
                $hash_id = $getFromDialogue->hash_id;
            }
        }

        if(!$only_my_dialog){

            $whom_token = $this->buildToken(["from_user_id"=>$params["whom_user_id"], "whom_user_id"=>$params["from_user_id"], "channel_id"=>$params["channel_id"]]);

            $getWhomDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["whom_user_id"],$whom_token]);

            if(!$getWhomDialogue){
                $whom_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["whom_user_id"], "from_user_id"=>$params["from_user_id"],"time_create"=>$date,"time_update"=>$date,"channel_id"=>(int)$params["channel_id"],"hash_id"=>$hash_id, "token"=>$whom_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getWhomDialogue->id);
                $hash_id = $getWhomDialogue->hash_id;
            }

        }

    }else{

        if(!$params["action"]){

            $from_token = $this->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"]]);

            $getFromDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$from_token]);

            if(!$getFromDialogue){
                $from_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["from_user_id"], "from_user_id"=>$params["whom_user_id"],"time_create"=>$date,"time_update"=>$date,"ad_id"=>(int)$params["ad_id"],"hash_id"=>$hash_id, "token"=>$from_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getFromDialogue->id);
                $hash_id = $getFromDialogue->hash_id;
            }

        }

        if(!$only_my_dialog){

            $whom_token = $this->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["whom_user_id"], "whom_user_id"=>$params["from_user_id"]]);

            $getWhomDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["whom_user_id"],$whom_token]);

            if(!$getWhomDialogue){
                $whom_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["whom_user_id"], "from_user_id"=>$params["from_user_id"],"time_create"=>$date,"time_update"=>$date,"ad_id"=>(int)$params["ad_id"],"hash_id"=>$hash_id, "token"=>$whom_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getWhomDialogue->id);
                $hash_id = $getWhomDialogue->hash_id;
            }

        }

    }

    return (object)["from_dialogue_id"=>$from_dialogue_id ?: $getFromDialogue->id, "whom_dialogue_id"=>$whom_dialogue_id ?: $getWhomDialogue->id, "hash_id"=>$hash_id, "from_token"=>$from_token, "whom_token"=>$whom_token];

}