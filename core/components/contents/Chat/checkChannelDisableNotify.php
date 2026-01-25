public function checkChannelDisableNotify($channel_id=0, $user_id=0){
    global $app;

    if($app->model->chat_channels_disable_notify->find("user_id=? and channel_id=?", [$user_id, $channel_id])){
        return true;
    }else{
        return false;
    }

}