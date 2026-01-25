public function updateActiveCountries(){
    global $app;
    $ids = [];
    $getActiveCountries = $app->model->geo_countries->getAll("status=?", [1]);
    if($getActiveCountries){
        foreach ($getActiveCountries as $key => $value) {
            $ids[] = $value["id"];
        }
    }
    $app->model->settings->update($ids ? _json_encode($ids) : null, "active_countries");
}