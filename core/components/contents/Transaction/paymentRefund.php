public function paymentRefund($data=[]){
    global $app;

    if($data){

        $data->operation = $this->getOperation($data->operation_id);

        if($data->operation->status_processing == "paid"){

            $app->model->transactions_operations->insert(["order_id"=>$data->order_id,"user_id"=>$data->from_user_id,"time_create"=>$app->datetime->getDate(), "data"=>encrypt(_json_encode($data->operation->data)), "status_processing"=>"awaiting_refund", "currency_code"=>$data->operation->currency_code, "amount"=>$data->amount, "callback_data"=>$data->operation->callback_data ? encrypt(_json_encode($data->operation->callback_data)) : null]);

            $app->addons->payment($data->operation->data["payment_id"])->createRefund($data);

            foreach ($data->operation->data["items"] as $key => $value) {
                $this->warehouseItem($value["id"],$value["count"],"+");
            }

        }

    }

}