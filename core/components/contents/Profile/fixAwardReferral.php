public function fixAwardReferral($user_id=0, $amount=0){
    global $app;

    if(!$app->settings->referral_program_status){
        return;
    }

    $award = calculatePercent($amount, $app->settings->referral_program_percent_award);

    if($award){

        $referral = $app->model->users_referrals->find("from_user_id=?", [$user_id]);

        if($referral){

            $app->model->users_referral_award->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$user_id, "whom_user_id"=>$referral->whom_user_id, "amount"=>$award]);

            $app->component->transaction->manageUserBalance(["user_id"=>$referral->whom_user_id, "amount"=>$award], "+");

            $app->event->fixAwardReferral(["from_user_id"=>$user_id, "whom_user_id"=>$referral->whom_user_id, "amount"=>$award]);

        }

    }

}