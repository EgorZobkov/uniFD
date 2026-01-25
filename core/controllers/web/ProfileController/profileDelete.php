public function profileDelete()
{   

    $this->user->delete($this->user->data->id);
    return json_answer(["status"=>true]);

}