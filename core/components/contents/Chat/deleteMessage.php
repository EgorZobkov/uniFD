public function deleteMessage($user_id=0, $message_id=0){
     global $app;

     if($user_id){
        $getMessage = $app->model->chat_messages->find("from_user_id=? and id=?", [$user_id, $message_id]);
     }else{
        $getMessage = $app->model->chat_messages->find("id=?", [$message_id]);
     }

     if($getMessage){
        if($getMessage->channel_id){
            $app->model->chat_messages->delete("id=?", [$message_id]);
            $app->model->chat_messages->delete("parent_message_id=?", [$message_id]);
            $app->storage->clearAttachFiles(_json_decode($getMessage->media));
        }else{
            $app->model->chat_messages->update(["delete_status"=>1], $message_id);
            $app->model->chat_messages->update(["delete_status"=>1], ["parent_message_id=?", [$message_id]]);
        }
     }

}