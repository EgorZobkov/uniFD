public function calculationDealProfit($amount=0, $delivery_amount=0){
    global $app;

    return calculatePercent($amount-$delivery_amount, $app->settings->secure_deal_profit_percent);

}