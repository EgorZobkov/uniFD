public function outPriceAndCurrency($data=[]){
    global $app;

    $data = (array)$data;

    $measure_title = '';

    if($data["price_gratis_status"]){
        return translate("tr_60183c67d880a855d91a9419f344e97e");
    }

    if($data["price"]){

        $measure = $app->model->system_measurements->find("id=?", [$data["price_measure_id"]]);

        if($measure){
            $measure_title = translate("tr_462eaa68988f6a1a10814f865d5160ad").' '.translateField($measure->name);
        }

        if($data["price_fixed_status"]){

            return $app->system->amount($data["price"], $data["currency_code"]).' '.$measure_title;

        }else{

            return translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data["price"], $data["currency_code"]).' '.$measure_title;

        }

    }

    return translate("tr_8d7254e709bd2fbc45c82c02d6d1e269");

}