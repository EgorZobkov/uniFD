public function getOperation($order_id=null){
    global $app;

    if($order_id){

        $order = $app->model->transactions_operations->find("order_id=?", [$order_id]);

        if($order){
            $order->data = _json_decode(decrypt($order->data));
            $order->callback_data = $order->callback_data ? _json_decode(decrypt($order->callback_data)) : null;
            $order->data["operation_id"] = $order->id;
        }

        return $order;

    }else{
        logger("Error payment not found order id");
        return [];
    }

}