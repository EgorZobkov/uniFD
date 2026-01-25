public function outPrices($data=[]){
    global $app;

    $measure_title = '';

    if($data->price_gratis_status){
        return '<span class="card-item-price-now" >'.translate("tr_60183c67d880a855d91a9419f344e97e").'</span>';
    }

    if($data->price){

        $measure = $app->model->system_measurements->find("id=?", [$data->price_measure_id]);

        if($measure){
            $measure_title = '<span class="card-item-price-measure-title" >'.translate("tr_462eaa68988f6a1a10814f865d5160ad").' '.translateField($measure->name).'</span>';
        }

        if($data->price_fixed_status){

            if($data->old_price){
                return '<span class="card-item-price-now" >'.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>
                <span class="card-item-price-old" >'.$app->system->amount($data->old_price, $data->currency_code).'</span>';
            }
            
            return '<span class="card-item-price-now" >'.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>';

        }else{

            if($data->old_price){
                return '<span class="card-item-price-now" >'.translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>
                <span class="card-item-price-old" >'.$app->system->amount($data->old_price, $data->currency_code).'</span>';
            }
            
            return '<span class="card-item-price-now" >'.translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data->price, $data->currency_code).$measure_title.'</span>';

        }

    }

    return '<span class="card-item-price-now" >'.translate("tr_8d7254e709bd2fbc45c82c02d6d1e269").'</span>';

}