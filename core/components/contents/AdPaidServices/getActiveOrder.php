public function getActiveOrder($ad_id=0, $service_id=0){
    global $app;

    return $app->model->ads_services_orders->find("ad_id=? and service_id=? and time_expiration > now()", [$ad_id, $service_id]);
  
}