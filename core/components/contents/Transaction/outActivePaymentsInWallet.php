public function outActivePaymentsInWallet(){
    global $app;

    $result  = '';

    if($app->settings->integration_payment_services_active){
        $payments = $app->model->system_payment_services->sort("id desc")->getAll("status=? and id IN(".implode(",", $app->settings->integration_payment_services_active).")", [1]);

        if($payments){
            foreach ($payments as $key => $value) {
                $result .= '<div class="option-payment-item option-payment-item-change-wallet '.($key == 0 ? 'active' : '').'" data-id="'.$value["alias"].'" >
                <div class="option-payment-item-logo" ><img src="'.$app->addons->payment($value["alias"])->logo().'" /></div> <div class="option-payment-item-name" ><strong>'.$value["name"].'</strong><span>'.$value["title"].'</span></div> 
                <input type="radio" name="payment_id" value="'.$value["alias"].'" '.($key == 0 ? 'checked=""' : '').' >
                </div>';
            }
        }
    }

    return $result;

}