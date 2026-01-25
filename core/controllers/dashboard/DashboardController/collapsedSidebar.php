public function collapsedSidebar(){

    $find = $this->model->system_customize_template->find("user_id=?", [$this->user->data->id]);

    if($find){
        $this->model->system_customize_template->update(["collapsed_sidebar"=>$_POST['status']], $find->id);
    }else{
        $this->model->system_customize_template->insert(["user_id"=>$this->user->data->id, "collapsed_sidebar"=>$_POST['status']]);
    }

    return json_answer(["status"=>true]);
}