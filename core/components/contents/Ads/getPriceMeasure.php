public function getPriceMeasure($measure_id=0){
    global $app;

    $measure = $app->model->system_measurements->find("id=?", [$measure_id]);
    if($measure){
        return $measure_id;
    }

    return 0;

}