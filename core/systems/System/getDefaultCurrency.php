public function getDefaultCurrency(){
    global $app;
    return $this->getCurrencyByCode($app->settings->system_default_currency);
}