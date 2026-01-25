public function isBlacklistСross($from_user_id=0, $whom_user_id=0){
    global $app;
    $check = $app->model->users_blacklist->find("(from_user_id=? and whom_user_id=?) or (whom_user_id=? and from_user_id=?)", [$from_user_id,$whom_user_id,$from_user_id,$whom_user_id]);
    if($check){
        return true;
    }
    return false;
}