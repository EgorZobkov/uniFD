public function delete()
{   

    $this->component->stories->delete($this->request->get('id'), $this->user->data->id);
    return json_answer(["status"=>true]);

}