public function load()
{   

    $result = $this->component->stories->load($this->request->get('id'), $this->user->data->id, $this->request->get('category_id'));
    return json_answer(["content"=>$result]);

}