public function getServiceSecureDeal(){
    global $app;

    if($app->settings->integration_payment_service_secure_deal_active){
        return $app->model->system_payment_services->find("status=? and id=?", [1,$app->settings->integration_payment_service_secure_deal_active]);
    }

    return [];

}