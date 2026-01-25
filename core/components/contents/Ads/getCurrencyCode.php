public function getCurrencyCode($currency=""){
    global $app;

    if($currency){
        if(compareValues($app->settings->system_extra_currency, $currency)){
            return $currency;
        }
    }

    return $app->settings->system_default_currency;

}