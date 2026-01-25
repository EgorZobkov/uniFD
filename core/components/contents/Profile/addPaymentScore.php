public function addPaymentScore($user_id=0, $score=null){
    global $app;

    if($score){

        $payment = $app->component->transaction->getServiceSecureDeal();

        if($payment){
            if($payment->type_score == "score_card"){
                if(!detectBankCardType($score)){
                    return ["status"=>false, "answer"=>translate("tr_3cd07360d2fd670264e306f1fe58d3c8")];
                }                    
            }
        }else{
            if(!detectBankCardType($score)){
                return ["status"=>false, "answer"=>translate("tr_3cd07360d2fd670264e306f1fe58d3c8")];
            }
        }

        if(!$app->model->users_payment_data->find("score=? and user_id=?", [$score,$user_id])){

            $app->model->users_payment_data->insert(["user_id"=>$user_id, "type_score"=>$payment ? $payment->type_score : "score_card", "score"=>encrypt($score), "default_status"=>$app->model->users_payment_data->count("default_status=? and user_id=?", [1,$user_id]) ? 0 : 1]);

            return ["status"=>true];

        }else{
            return ["status"=>false, "answer"=>translate("tr_b93f5f3864fa383e2f3e0ac1758f153f")];
        }

    }else{
        return ["status"=>false, "answer"=>translate("tr_528a67adc943ea4fa07bf40c87be8294")];
    }

}