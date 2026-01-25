public function getDialogueDashboard($dialogue_id=0, $channel_id=0){
    global $app;

    $date = $app->datetime->getDate();

    $messages = [];

    $getChannel = $app->model->chat_channels->find("id=?", [$channel_id]);

    if($getChannel){

        if($getChannel->type == "support"){

            $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [0,$dialogue_id]);

            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=? and (user_id=? or whom_user_id=?)", [$getDialogue->hash_id, $getDialogue->user_id, $getDialogue->user_id]]);

            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("dialogue_id=? and channel_id=?", [$dialogue_id,$channel_id]);

        }elseif($getChannel->type == "closed"){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=?", [$channel_id]);
        }elseif($getChannel->type == "public"){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=?", [$channel_id]);
        }

        if($getMessages){

            $reverse = array_reverse($getMessages, true);

            foreach ($reverse as $key => $value) {

                $messages[$app->datetime->format("d.m.Y")->getDate($value["time_create"])][] = $value;

            }

        }

    }

    return (object)["messages"=>$messages, "channel"=>$getChannel ?: [], "dialogue"=>$getDialogue ?: [], "token"=>$getDialogue ? $getDialogue->token : ""];     

}