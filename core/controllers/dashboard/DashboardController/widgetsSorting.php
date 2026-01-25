public function widgetsSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->system_home_users_widgets->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}