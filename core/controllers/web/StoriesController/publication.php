public function publication()
{   

    $result = $this->component->stories->publication($this->request->request->all(), $this->user->data->id);
    return json_answer($result);

}