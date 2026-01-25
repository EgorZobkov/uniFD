public function hasAvailableDelivery($ad=[], $data=[]){
    global $app;

    $data = (object)$data;

    $user_shipping = $app->model->users_shipping_points->find("delivery_id=? and user_id=?", [$data->id, $ad->user->id]);

    if($ad->delivery_status == 1 && $ad->user->delivery_status && $user_shipping){

        if($ad->price >= $data->available_price_min && ($ad->price <= $data->available_price_max || !$data->available_price_max) && $ad->category->delivery_size_weight >= $data->min_weight && ($ad->category->delivery_size_weight <= $data->max_weight || !$data->max_weight)){
            return true;
        }

    }

    return false;

}