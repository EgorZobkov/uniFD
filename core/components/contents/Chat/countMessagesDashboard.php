public function countMessagesDashboard($channel_id=0){
     global $app;

     if($channel_id){
         return $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,$channel_id]);
     }else{
         return $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,1]);
     }

}