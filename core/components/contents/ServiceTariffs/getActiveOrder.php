public function getActiveOrder($user_id=0){
    global $app;

    return $app->model->users_tariffs_orders->find("user_id=? and (time_expiration > now() or time_expiration is null)", [$user_id]);
  
}