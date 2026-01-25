public function outSectionContent(){
    global $app;
    if($app->router->currentRoute->name == "dashboard-settings"){
        $section = $app->model->system_settings_sections->sort("sorting asc")->find("default_section=?", [1]);
    }else{
        $section = $app->model->system_settings_sections->sort("sorting asc")->find("route_name=?", [$app->router->currentRoute->name]);
    }
    return $app->view->includeComponent("settings/{$section->section_id}.tpl");
}