public function sendMessageChat($data = []){
    global $app;

    if($data["whom_user_id"] == 0){
        $app->component->chat->sendAction("first_message_support", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"]], false);
    }

    if($app->component->chat->hasContactInformationInMessage($data["text"])){
        $app->component->chat->sendAction("system_warning_contacts", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"], "ad_id"=>$data["ad_id"]], false);
    }
    
}