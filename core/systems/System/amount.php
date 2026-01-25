public function amount($amount=0, $currency_code=null){
    global $app;

    if(isset($currency_code)){
        $currency_code = $this->getCurrencyByCode($currency_code)->symbol;
    }else{
        if($app->settings->system_default_currency){
            $currency_code = $this->getDefaultCurrency()->symbol;
        }else{
            $currency_code = "$";
        }
    }

    $amountFormat = numberFormat($amount,2,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);

    if(explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '0' && explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '00'){
        $amountExplode = explode($app->settings->system_price_fraction_separator,$amountFormat);
        $amount = $amountExplode[0].".".$amountExplode[1];
    }else{
        $amount = numberFormat($amount,0,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);
    }
   
    if($app->settings->system_currency_spacing){ $spacing = " "; }else{ $spacing = ""; }

    if($app->settings->system_currency_position == "start"){
        return $currency_code.$spacing.$amount;
    }else{
        return $amount.$spacing.$currency_code;
    }

}