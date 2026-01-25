public function outPriceDifferentCurrenciesInAdCard($data=[]){
    global $app;
    return '';
    if($app->settings->board_card_price_different_currencies){
        if($data->price && !$data->price_gratis_status){
            return  '
                <div class="ad-card-prices-currency" >
                  <span>106,383 $</span>
                  <span>96,154 €</span>                  
                </div>
            ';
        }
    }

}