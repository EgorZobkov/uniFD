public function totalCountTransitionsReferral($user_id=0){
    global $app;
    return $app->model->users_referral_transitions->count("user_id=?", [$user_id]);
}