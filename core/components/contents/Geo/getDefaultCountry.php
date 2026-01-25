public function getDefaultCountry(){
    global $app;
    $get = $app->model->geo_countries->find("default_status=? and status=?", [1,1]);
    if(!$get){
        $get = $app->model->geo_countries->find("status=?", [1]);
    }
    return $get;
}