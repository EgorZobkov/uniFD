public function getDealByOrderId($order_id=0){
    global $app;

    $data = $app->model->transactions_deals->find("order_id=?", [$order_id]);

    if($data){

        if($data->delivery_service_id){
            $data->delivery_service = $app->model->system_delivery_services->find("id=?", [$data->delivery_service_id]);
            $data->delivery_data = _json_decode(decrypt($data->delivery_data));
            $data->delivery_point = $app->model->delivery_points->find("code=?", [$data->delivery_data["point_code"]]);
            $data->user_shipping = $app->model->users_shipping_points->find("user_id=? and delivery_id=?", [$data->whom_user_id, $data->delivery_service_id]);
        }

        if($data->delivery_answer_data){
            $data->delivery_answer_data = _json_decode($data->delivery_answer_data);
            $data->user_shipping_point = $app->model->delivery_points->find("code=?", [$data->delivery_answer_data["shipping_point_code"]]);
        }

        $getItem = $app->model->transactions_deals_items->find("order_id=?", [$order_id]);

        $data->item = $app->component->ads->getAd($getItem->item_id);

        if($data->item){

            $data->item->count = $getItem->count;
            $data->item->amount = $getItem->amount;
            $data->item->external_content = $getItem->external_content;

            $data->from_user = $app->model->users->findById($data->from_user_id);
            $data->whom_user = $app->model->users->findById($data->whom_user_id);

            return $data;

        }
        
    }

    return [];

}