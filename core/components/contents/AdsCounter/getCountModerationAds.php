public function getCountModerationAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=?", [0]),0,'.', ' ');
}