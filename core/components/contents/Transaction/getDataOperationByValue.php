public function getDataOperationByValue($data=[]){
    global $app;

    $data["user"] = $app->model->users->findById($data["user_id"]);
    $data["data"] = _json_decode($data["data"]);
    $data["service_payment"] = $this->getPaymentService($data["data"]["payment_id"]);

    return (object)$data;

}