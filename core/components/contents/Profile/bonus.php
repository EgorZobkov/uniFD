public function bonus($user_id=0){
    global $app;

    if($app->settings->registration_bonus_status){

        $app->component->transaction->manageUserBalance(["user_id"=>$user_id, "amount"=>$app->settings->registration_bonus_amount, "text"=>translate("tr_8d84a0cdf8be0221a8f814a68ef43b98")], "+");
    }

}