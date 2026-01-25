public function updateCountMessages($user_id=0, $notification=false){
     global $app;

     $count = 0;
     $count_notify = 0;
     $count_in_channel = 0;
     $total_count_in_channel = 0;

     if($notification){
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and notification_status=?", [$user_id,$user_id,0,0,0]);
     }else{
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=?", [$user_id,$user_id,0,0]);
     }

     $getChannels = $app->model->chat_channels->getAll("type!=? and status=?", ["support",1]);
     if($getChannels){
        foreach ($getChannels as $value) {

            $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$value["id"],$user_id]);
            if(!$getView){
                if($notification){
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=? and notification_status=?", [$value["id"],$user_id,0,0]);
                }else{
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$value["id"],$user_id,0]);
                }
            }else{
                if($notification){
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=? and notification_status=?", [$value["id"],$getView->message_id,$user_id,0,0]);
                }else{
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$value["id"],$getView->message_id,$user_id,0]);
                }
            }

            if(!$this->checkChannelDisableNotify($value["id"], $user_id)){
                $count_notify += $count_in_channel;
            }

            $total_count_in_channel += $count_in_channel;

        }
     }

     return ["count"=>$count+$total_count_in_channel, "notify"=>$count+$count_notify];

}