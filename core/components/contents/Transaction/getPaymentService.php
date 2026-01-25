public function getPaymentService($aliasOrId=null){
    global $app;

    if($aliasOrId){
        return $app->model->system_payment_services->find("alias=? or id=?", [$aliasOrId, $aliasOrId]);
    }

    return [];

}