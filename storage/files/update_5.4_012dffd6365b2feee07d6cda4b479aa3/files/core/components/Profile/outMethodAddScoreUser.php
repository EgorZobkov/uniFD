public function outMethodAddScoreUser($user_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment->type_score != "add_card"){
        return '
          <div class="credit-card-add openModal" data-modal-id="addPaymentScoreModal" >
              <div>'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</div>
          </div>
        ';
    }else{

        if(!$app->model->users_payment_data->find("user_id=? and type_score=?", [$user_id, "add_card"])){
            return '
              <div class="credit-card-add actionAddPaymentCardToLink" >
                  <div>'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</div>
              </div>
            ';
        }
        
    }

}