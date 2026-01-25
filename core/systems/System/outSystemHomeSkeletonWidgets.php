public function outSystemHomeSkeletonWidgets(){
    global $app;

    $getUserWidgets = $app->model->system_home_users_widgets->sort("sorting asc")->getAll("user_id=?", [$app->user->data->id]);
    if($getUserWidgets){
        foreach ($getUserWidgets as $key => $value) {
            $widget = $app->model->system_home_widgets->find("id=?", [$value["widget_id"]]);
            echo $app->view->setParamsComponent(['data'=>(object)$value, 'widget'=>$widget])->includeComponent("home/skeleton.tpl");
        }
    }else{
        echo $app->ui->wrapperInfo('dashboard-no-widgets-home');
    }
        
}