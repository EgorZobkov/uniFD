public function getCountAllAds(){
    global $app;
    return numberFormat($app->model->ads_data->count(),0,'.', ' ');
}