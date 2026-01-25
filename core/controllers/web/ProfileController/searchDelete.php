public function searchDelete()
{   

    $this->model->users_searches->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);
    return json_answer(["status"=>true]);
    
}