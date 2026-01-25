public function userActivityStatus($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return true;
        }else{
            return false;
        }
    }
    return false;
}