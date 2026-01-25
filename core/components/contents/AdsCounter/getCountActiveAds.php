public function getCountActiveAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=?", [1]),0,'.', ' ');
}