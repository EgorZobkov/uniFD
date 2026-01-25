public function getPaymentData($user_id=0){
    global $app;
    $payment = $app->model->users_payment_data->find("user_id=? and default_status=?", [$user_id, 1]);
    if($payment){
        $payment->score = decrypt($payment->score);
        $payment->service = $app->component->transaction->getServiceSecureDeal();
        return $payment;
    }
    return [];
}