public function widgetRemove(){

    $this->model->system_home_users_widgets->delete("id=? and user_id=?", [$_POST["id"],$this->user->data->id]);

    return json_answer(["status"=>true]);

}