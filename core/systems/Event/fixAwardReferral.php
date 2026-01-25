public function fixAwardReferral($data = []){
    global $app;

    $app->notify->params(["amount"=>$app->system->amount($data["amount"])])->userId($data["whom_user_id"])->code("referral_accrued_award")->addWaiting();

}