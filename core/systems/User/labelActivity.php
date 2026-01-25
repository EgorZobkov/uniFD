public function labelActivity($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return translate("tr_49baa6a68525093720247b1c9012ec2b");
        }else{
            return translate("tr_136d70f1713206f5bf8c4506cd4d1e6f").' '.$app->datetime->outLastTime($time_last_activity);
        }
    }
    return '';
}