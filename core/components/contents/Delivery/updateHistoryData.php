 public function updateHistoryData($data=[]){
    global $app;

    $result = [];

    $service = $app->model->system_delivery_services->find("id=?", [(int)$data["delivery_service_id"]]);
    if($service){
        $data["delivery_history_data"] = $data["delivery_history_data"] ? _json_decode(decrypt($data["delivery_history_data"])) : [];
        $data["delivery_answer_data"] = $data["delivery_answer_data"] ? _json_decode($data["delivery_answer_data"]) : [];
        $result = $app->addons->delivery($service->alias)->getHistory($data);
        if($result["status"] == true){
            $app->model->transactions_deals->update(["delivery_history_data"=>encrypt(_json_encode($result["data"]))], ["order_id=?", [$data["order_id"]]]);
            if($result["sending_status"] == true){
                $app->model->transactions_deals->update(["status_processing"=>"confirmed_send_shipment"], ["order_id=?", [$data["order_id"]]]);
            }
        }
    }

    return $result;

}