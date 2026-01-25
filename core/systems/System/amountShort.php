public function amountShort($amount=0, $currency_code=null){
    global $app;

    if(!$app->settings->system_price_reduction_status){
        return $this->amount($amount, $currency_code);
    }

    if(isset($currency_code)){
        $currency_code = $this->getCurrencyByCode($currency_code)->symbol;
    }else{
        if($app->settings->system_default_currency){
            $currency_code = $this->getDefaultCurrency()->symbol;
        }else{
            $currency_code = "$";
        }
    }

    if($amount >= 1000000 && $amount <= 9999999){
        
        if(substr($amount, 1,1) != 0){
           $amount = substr($amount, 0,1).','.substr($amount, 1,1).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");
        }else{
           $amount = substr($amount, 0,1).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");
        }

    }elseif( $amount >= 10000000 && $amount <= 99999999 ){

        $amount = substr($amount, 0,2).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");

    }elseif($amount >= 100000000 && $amount <= 999999999){

        $amount = substr($amount, 0,3).' '.translate("tr_6b884b09b6a84c56f4624a2d67b42682");

    }elseif($amount >= 1000000000 && $amount <= 9999999999){

        if(substr($amount, 1,1) != 0){
           $amount = substr($amount, 0,1).','.substr($amount, 1,1).' '.translate("tr_f6ed0cf8f656bd20b3696b469eecf9fd");
        }else{
           $amount = substr($amount, 0,1).' '.translate("tr_f6ed0cf8f656bd20b3696b469eecf9fd");
        }

    }else{
        
        $amountFormat = numberFormat($amount,2,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);

        if(explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '0' && explode($app->settings->system_price_fraction_separator, $amountFormat)[1] != '00'){
            $amountExplode = explode($app->settings->system_price_fraction_separator,$amountFormat);
            $amount = $amountExplode[0].".".$amountExplode[1];
        }else{
            $amount = numberFormat($amount,0,$app->settings->system_price_fraction_separator,$app->settings->system_price_separator == "spacing" ? " " : $app->settings->system_price_separator);
        }

    }        

    if($app->settings->system_currency_spacing){ $spacing = " "; }else{ $spacing = ""; }

    if($app->settings->system_currency_position == "start"){
        return $currency_code.$spacing.$amount;
    }else{
        return $amount.$spacing.$currency_code;
    }

}