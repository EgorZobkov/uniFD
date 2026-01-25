public function getDialogue($params=[], $only_new_messages = false){
    global $app;

    $date = $app->datetime->getDate();

    $messages = [];
    $ad = [];
    $user = [];
    $getMessages = [];

    if($params["token"]){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);

        if(!$getDialogue){
            $this->createDialogue($params, true);
            $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);
        }

        if($getDialogue->ad_id){
            $ad = $app->component->ads->getAd($getDialogue->ad_id);
        }

        $user = $app->model->users->findById($getDialogue->from_user_id);

        if($only_new_messages){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and dialogue_id=? and status=? and from_user_id!=? and delete_status=?", [$params["from_user_id"],$getDialogue->id,0,$params["from_user_id"],0]);
        }else{
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and dialogue_id=? and delete_status=?", [$params["from_user_id"],$getDialogue->id,0]);
        }

        $lastMessage = $app->model->chat_messages->sort("id desc")->find('hash_id=? and delete_status=?', [$getDialogue->hash_id,0]);

        if($params["from_user_id"] != $lastMessage->from_user_id){
            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=?", [$getDialogue->hash_id]]);
        }

    }elseif($params["channel_id"]){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$params["channel_id"], 1]);

        if(!$getChannel){
            return [];
        }

        if($getChannel->type == "support"){

            $getDialogue = $app->model->chat_dialogues->find("user_id=? and channel_id=?", [$params["from_user_id"],$getChannel->id]);

            if($only_new_messages){
                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and channel_id=? and status=? and from_user_id!=? and delete_status=?", [$params["from_user_id"],$getChannel->id,0,$params["from_user_id"],0]);
            }else{
                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and channel_id=? and delete_status=?", [$params["from_user_id"],$getChannel->id,0]);
            }

            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=? and (user_id=? or whom_user_id=?)", [$getDialogue->hash_id, $params["from_user_id"], $params["from_user_id"]]]);            

        }elseif($getChannel->type == "closed" || $getChannel->type == "public"){

            if($only_new_messages){

                $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$getChannel->id,$params["from_user_id"]]);
                if($getView){
                    $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=? and from_user_id!=? and delete_status=? and id > ? and delete_status=?", [$getChannel->id,$params["from_user_id"], 0, $getView->message_id, 0]);
                }

            }else{

                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=? and delete_status=?", [$getChannel->id,0]);

            }

            $lastMessage = $app->model->chat_messages->sort("id desc")->find('channel_id=?', [$getChannel->id]);

            if($lastMessage){
                if(!$app->model->chat_channels_view->find("channel_id=? and message_id=? and user_id=?", [$getChannel->id,$lastMessage->id,$params["from_user_id"]])){
                    $app->model->chat_channels_view->insert(["channel_id"=>$getChannel->id, "message_id"=>$lastMessage->id, "user_id"=>$params["from_user_id"]]);
                }
            }

        }

    }

    if($getMessages){

        $reverse = array_reverse($getMessages, true);

        foreach ($reverse as $key => $value) {

            $messages[$app->datetime->format("d.m.Y")->getDate($value["time_create"])][] = $value;

        }

    }

    return (object)["messages"=>$messages, "ad"=>$ad, "user"=>$user, "channel"=>$getChannel ? $getChannel : [], "token"=>$params["token"] ?: "", "dialogue"=>$getDialogue ?: []];     
}