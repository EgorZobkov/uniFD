 public function getStat(){
    global $app;
    
    return (object)["total_install"=>$app->model->mobile_stat->count(),"today_install"=>$app->model->mobile_stat->count("DATE(time_create)=?", [$app->datetime->format("Y-m-d")->getDate()]), "active_sessions"=>$app->model->mobile_stat->count("unix_timestamp(time_update) + 180 > unix_timestamp(now())"), "active_sessions_list"=>$app->model->mobile_stat->getAll("unix_timestamp(time_update) + 180 > unix_timestamp(now())")];
 }