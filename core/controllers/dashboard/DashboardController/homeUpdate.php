public function homeUpdate()
{   

    $content = [];
    $getUserWidgets = $this->model->system_home_users_widgets->sort("sorting asc")->getAll("user_id=?", [$this->user->data->id]);
    if($getUserWidgets){
        foreach ($getUserWidgets as $key => $value) {
            $widget = $this->model->system_home_widgets->find("id=?", [$value["widget_id"]]);
            $data = $this->view->setParamsComponent(['data'=>(object)$value, 'widget'=>$widget])->includeComponent("home/widgets/{$widget->template_name}.tpl");
            $content[$value["id"]] = ["hash"=>hash('sha256', $data), "data"=>$data];
        }
    }

    return json_answer($content);

}