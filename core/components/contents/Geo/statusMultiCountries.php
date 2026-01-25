public function statusMultiCountries(){
    global $app;

    if($app->settings->active_countries){
        if(count($app->settings->active_countries) > 1){
            return true;
        }
    }

    return false;

}