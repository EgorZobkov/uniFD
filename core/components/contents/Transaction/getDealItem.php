public function getDealItem($order_id=0){
    global $app;

    $data = $app->model->transactions_deals->find("order_id=?", [$order_id]);

    if($data){

        $data->item = $app->model->transactions_deals_items->find("order_id=?", [$order_id]);

        if($data->delivery_service_id){
            $data->delivery_service = $app->model->system_delivery_services->find("id=?", [$data->delivery_service_id]);
            $data->delivery_data = _json_decode(decrypt($data->delivery_data));
            $data->delivery_point = $app->model->delivery_points->find("code=?", [$data->delivery_data["point_code"]]);
            $data->user_shipping = $app->model->users_shipping_points->find("user_id=? and delivery_id=?", [$data->whom_user_id, $data->delivery_service_id]);

            if($data->user_shipping){
                $data->user_shipping_point = $app->model->delivery_points->find("code=?", [$data->user_shipping->point_code]);
            }

            if($data->delivery_answer_data){
                $data->delivery_answer_data = _json_decode($data->delivery_answer_data);
            }

        }

        return $data;
    }

    return [];

}