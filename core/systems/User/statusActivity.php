public function statusActivity($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return true;
        }
    }
    return false;
}