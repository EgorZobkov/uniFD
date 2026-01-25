public function searchItemsCombined(){

    $result = $this->component->search->searchItemsCombined($_POST["query"], $this->user->data->id);

    return json_answer($result);

}