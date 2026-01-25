public function isSubscription($from_user_id=0, $whom_user_id=0){
    global $app;
    if($app->model->users_subscriptions->find("user_id=? and whom_user_id=?", [$from_user_id,$whom_user_id])){
        return true;
    }
    return false;
}