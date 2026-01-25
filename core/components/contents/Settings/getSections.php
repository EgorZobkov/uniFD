public function getSections(){
    global $app;
    return $app->model->system_settings_sections->sort("sorting asc")->getAll();
}