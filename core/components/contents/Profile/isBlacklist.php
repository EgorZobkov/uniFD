public function isBlacklist($from_user_id=0, $whom_user_id=0, $channel_id=0){
    global $app;
    if($channel_id){
        $check = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=? and channel_id=?", [$from_user_id,$whom_user_id,$channel_id]);
    }else{
        $check = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=?", [$from_user_id,$whom_user_id]);
    }
    if($check){
        return true;
    }
    return false;
}