public function channelDisableNotify($channel_id=0, $user_id=0){
    global $app;

    $getChannel = $app->model->chat_channels->find("id=?", [$channel_id]);

    if($getChannel->type != "support"){

        $get = $app->model->chat_channels_disable_notify->find("user_id=? and channel_id=?", [$user_id, $channel_id]);

        if($get){

            $app->model->chat_channels_disable_notify->delete("id=?", [$get->id]);

            return false;

        }else{

            $app->model->chat_channels_disable_notify->insert(["user_id"=>$user_id, "channel_id"=>$channel_id]);

            return true;

        }

    }

}