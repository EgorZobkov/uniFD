public function deliveryHistory(){

    $data = $this->model->transactions_deals->getAll("status_processing=? and delivery_service_id!=?", ["confirmed_order", 0]);
    if($data){

        foreach ($data as $key => $value) {
            $this->component->delivery->updateHistoryData($value);
        }

    }

}