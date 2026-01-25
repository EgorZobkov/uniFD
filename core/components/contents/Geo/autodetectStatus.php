public function autodetectStatus(){
    global $app;

    if($app->settings->active_countries){
        if($app->settings->geo_autodetect){
            return true;
        }
    }   

    return false;           

}