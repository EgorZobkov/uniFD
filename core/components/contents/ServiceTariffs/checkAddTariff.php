public function checkAddTariff($tariff_id=0, $user_id=0){
    global $app;

    $tariff = $app->model->users_tariffs->find("id=?", [$tariff_id]);

    if($app->model->users_tariffs_onetime->find("user_id=? and tariff_id=?", [$user_id, $tariff_id])){
        return ["status"=>false, "answer"=>translate("tr_efab01bfb749713014c7f707071f1cb9")];
    }

    $order = $this->getActiveOrder($user_id);

    if($order){
        if($tariff->price < $order->amount){
            return ["status"=>false, "answer"=>translate("tr_b5eb978a817f0e6aa1dd5257e7650571")];
        }
    }

    return [];
  
}