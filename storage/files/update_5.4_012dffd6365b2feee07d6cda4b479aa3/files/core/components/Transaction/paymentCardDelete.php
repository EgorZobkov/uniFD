public function paymentCardDelete($user_id=0, $card_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment){
        return $app->addons->payment($payment->alias)->deleteCard(["user_id"=>$user_id, "card_id"=>$card_id]);
    }

    return ["status"=>false];

}