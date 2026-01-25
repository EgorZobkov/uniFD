public function getTotalUsersOnline($key = null){
    global $app;
    if(isset($key)){
        if($key == "administrators"){
            return $app->model->users->count("admin=? and unix_timestamp(time_last_activity)+300 > unix_timestamp(now())", [1]);
        }elseif($key == "users"){
            return $app->model->users->count("admin=? and unix_timestamp(time_last_activity)+300 > unix_timestamp(now())", [0]);
        }
    }
}