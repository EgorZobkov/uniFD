public function getTariffData($tariff_id=0, $count=1){
    global $app;

    $getTariff = $app->model->users_tariffs->find("id=? and status=?", [$tariff_id,1]);
    if($getTariff){

        if($getTariff->count_day_fixed){
            return ["count"=>$getTariff->count_day, "amount"=>$getTariff->price, "name"=>$getTariff->name];
        }else{
            return ["count"=>0, "amount"=>$getTariff->price, "name"=>$getTariff->name];
        }

    }

    return [];

}