public function getViewsToday($ad_id=0){
    global $app;

    return  $app->model->ads_views->count("ad_id=? and date(time_create)=?", [$ad_id,$app->datetime->format("Y-m-d")->getDate()]);

}