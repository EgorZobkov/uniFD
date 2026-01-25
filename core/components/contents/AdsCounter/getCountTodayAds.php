public function getCountTodayAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=? and date(time_create)=?", [1, $app->datetime->format("Y-m-d")->getDate()]),0,'.', ' ');
}