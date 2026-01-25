public function countMessages($user_id=0, $dialogue_id=0, $channel_id=0){
     global $app;

     $count = 0;

     if($dialogue_id){
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and dialogue_id=?", [$user_id,$user_id,0,0,$dialogue_id]);
     }elseif($channel_id){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$channel_id,1]);

        if($getChannel->type == "support"){
            $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [$user_id,$user_id,0,0,$channel_id]);
        }else{ 
            if($getChannel){
                $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$getChannel->id,$user_id]);
                if(!$getView){
                    $count = $count + $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$getChannel->id,$user_id,0]);
                }else{
                    $count = $count + $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$getChannel->id,$getView->message_id,$user_id,0]);
                }
            }
        }

     }else{

        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=?", [$user_id,$user_id,0,0]);

        $getChannels = $app->model->chat_channels->getAll("type!=? and status=?", ["support",1]);
        if($getChannels){
            foreach ($getChannels as $value) {

                if(!$this->checkChannelDisableNotify($value["id"], $user_id)){

                    $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$value["id"],$user_id]);
                    if(!$getView){
                        $count = $count + $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$value["id"],$user_id,0]);
                    }else{
                        $count = $count + $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$value["id"],$getView->message_id,$user_id,0]);
                    }

                }

            }
        }

     }

     return $count;

}