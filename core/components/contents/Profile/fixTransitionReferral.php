public function fixTransitionReferral($alias=null){
    global $app;

    if(!$app->settings->referral_program_status || !$alias){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    $user = $app->model->users->find("alias=?", [$alias]);

    if($user){
        if($user->id != $app->user->data->id){
            if(!$app->model->users_referral_transitions->find("user_id=? and session_id=?", [$user->id,$session_id])){
                $app->model->users_referral_transitions->insert(["time_create"=>$app->datetime->getDate(), "user_id"=>$user->id, "session_id"=>$session_id, "ip"=>getIp()]);
            }
        }
    }

}