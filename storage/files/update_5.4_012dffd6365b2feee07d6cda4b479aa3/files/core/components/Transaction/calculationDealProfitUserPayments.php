public function calculationDealProfitUserPayments($amount=0, $delivery_amount=0){
    global $app;

    if($delivery_amount){
        $amount = $amount-$delivery_amount;
    }

    return $amount - calculatePercent($amount, $app->settings->secure_deal_profit_percent);
}