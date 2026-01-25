public function optionsPayment($params=[]){
    global $app;

    $amount = $this->getPaymentTargetAmount($params);

    $result = '<form class="option-payment-form" >';

    if($app->settings->profile_wallet_status){
        $result .= '<div class="option-payment-item option-payment-item-change active" data-id="balance" >
        <div class="option-payment-item-logo" ><img src="'.$app->storage->getAssetImage("wallet-6380789.webp").'" /></div> <div class="option-payment-item-name" ><strong>'.translate("tr_f3bffc80fd1707f0e93d8acf0ff2e2e8").'</strong><span>'.translate("tr_6f0f3c9e7ffb8294e60a60cf176efa67").' '.$app->user->data->balance_by_currency.'</span></div>
        <input type="radio" name="payment_id" value="balance" checked="" >
        </div>';
    }

    if($app->settings->integration_payment_services_active){
        $payments = $app->model->system_payment_services->sort("id desc")->getAll("status=? and id IN(".implode(",", $app->settings->integration_payment_services_active).")", [1]);

        if($payments){
            foreach ($payments as $key => $value) {
                $result .= '<div class="option-payment-item option-payment-item-change" data-id="'.$value["alias"].'" for="payment-item-'.$value["alias"].'" >
                <div class="option-payment-item-logo" ><img src="'.$app->addons->payment($value["alias"])->logo().'" /></div> <div class="option-payment-item-name" ><strong>'.$value["name"].'</strong><span>'.$value["title"].'</span></div>
                <input type="radio" name="payment_id" value="'.$value["alias"].'" >
                </div>';
            }
        }
    }

    $result .= '
        <div class="text-end mt-4">
            <button class="btn-custom button-color-scheme1 initTargetPayment" >'.translate("tr_4caffb2a58fc0bd6f790d3e85b054125").' '.$app->system->amount($amount).'</button>
        </div>

        <input type="hidden" name="params" value="'.urlencode(_json_encode($params)).'" />

        </form>
    ';

    return $result;

}