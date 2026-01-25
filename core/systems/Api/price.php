public function price($data=[]){
    global $app;

    return ["now"=>$this->outPriceAndCurrency($data["ad"]), "old"=>$data["ad"]->old_price ? $app->system->amount($data["ad"]->old_price, $data["ad"]->currency_code) : null];
}