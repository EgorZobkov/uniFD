public function getViews($ad_id=0){
    global $app;

    return $app->model->ads_views->count("ad_id=?", [$ad_id]);

}