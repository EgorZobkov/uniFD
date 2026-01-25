public function fixReferral($user_id=0){
    global $app;

    if(!$app->settings->referral_program_status){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    $transition = $app->model->users_referral_transitions->find("session_id=?", [$session_id]);

    if($transition){
        if(!$app->model->users_referrals->find("from_user_id=? and whom_user_id=?", [$user_id,$transition->user_id])){
            $app->model->users_referrals->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$user_id, "whom_user_id"=>$transition->user_id]);
            $app->event->fixReferral(["from_user_id"=>$user_id, "whom_user_id"=>$transition->user_id]);
        }
    }

}