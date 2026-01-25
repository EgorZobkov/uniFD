public function buildPaymentButton($params=[]){
    global $app;

    $amount = $this->getPaymentTargetAmount($params);

    if($params["button_name"]){
        $button_name = $params["button_name"];
    }else{
        $button_name = translate("tr_4caffb2a58fc0bd6f790d3e85b054125").' '.$app->system->amount($amount);
    }

    return '<button class="initOptionsPayment '.$params["class"].'" data-params="'.urlencode(_json_encode($params)).'" >'.$button_name.'</button>';

}