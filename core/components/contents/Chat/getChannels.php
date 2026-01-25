public function getChannels($user_id=0){
    global $app;

    $channels = [];

    $getChannels = $app->model->chat_channels->getAll("status=?", [1]);

    if($getChannels){
        foreach ($getChannels as $key => $value) {

            if($value["type"] == "support"){
                $lastMessage = $app->model->chat_messages->sort("id desc")->find('user_id=? and channel_id=? and delete_status=?', [$user_id,$value["id"],0]);
            }else{
                $lastMessage = $app->model->chat_messages->sort("id desc")->find('channel_id=? and delete_status=?', [$value["id"],0]);
            }
           
            $channels[] = arrayToObject(["item"=>$value, "last_message"=>$lastMessage ?: []]);

        }
    }

    return $channels;
    
}