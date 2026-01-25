public function paymentCardAdd($user_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment){
        return $app->addons->payment($payment->alias)->addCard(["user_id"=>$user_id]);
    }

    return ["status"=>false];

}