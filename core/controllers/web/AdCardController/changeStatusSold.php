public function changeStatusSold(){

    $this->model->ads_data->update(["status"=>7], ["id=? and user_id=?", [$_POST['id'], $this->user->data->id]]);

    return json_answer(["status"=>true]);
    
}