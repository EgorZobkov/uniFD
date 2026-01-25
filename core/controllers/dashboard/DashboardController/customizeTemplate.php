public function customizeTemplate(){

    $find = $this->model->system_customize_template->find("user_id=?", [$this->user->data->id]);

    if($find){
        $this->model->system_customize_template->update(["theme_color"=>$_POST['template_theme_color'], "position_menu"=>$_POST['template_position_menu'], "direction"=>$_POST['template_direction'], "language"=>$_POST['template_language']], $find->id);
    }else{
        $this->model->system_customize_template->insert(["user_id"=>$this->user->data->id, "theme_color"=>$_POST['template_theme_color'], "position_menu"=>$_POST['template_position_menu'], "direction"=>$_POST['template_direction'], "language"=>$_POST['template_language']]);
    }

    if($_POST["template_home_widgets"]){

        $getUserWidgets = $this->model->system_home_users_widgets->getAll("user_id=?", [$this->user->data->id]);
        if($getUserWidgets){
            foreach ($getUserWidgets as $key => $value) {
                if(!in_array($value["widget_id"], $_POST["template_home_widgets"])){
                    $this->model->system_home_users_widgets->delete("id=?", [$value["id"]]);
                }
            }
            foreach ($_POST["template_home_widgets"] as $key => $id) {
                $findUserWidget = $this->model->system_home_users_widgets->find("user_id=? and widget_id=?", [$this->user->data->id,$id]);
                if(!$findUserWidget){
                    $findWidget = $this->model->system_home_widgets->find("id=?", [$id]);
                    $this->model->system_home_users_widgets->insert(["user_id"=>$this->user->data->id, "widget_id"=>$id, "sorting"=>$findWidget->sorting]);
                }
            }
        }else{

            if(isset($_POST["template_home_widgets"])){
                foreach ($_POST["template_home_widgets"] as $id) {
                    $findWidget = $this->model->system_home_widgets->find("id=?", [$id]);
                    $this->model->system_home_users_widgets->insert(["user_id"=>$this->user->data->id, "widget_id"=>$id, "sorting"=>$findWidget->sorting]);
                }
            }           

        }

    }else{
        $this->model->system_home_users_widgets->delete("user_id=?", [$this->user->data->id]);
    }

    return json_answer(["status"=>true]);

}