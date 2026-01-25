public function getCurrencyByCode($code=null){
    global $app;
    $currency = (array)$app->config->currency;
    return $currency[$code];
}