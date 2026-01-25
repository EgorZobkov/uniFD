public function saveSearch(){

    $result = $this->component->profile->saveCatalogSearch($_POST, $this->user->data->id);
    return json_answer($result);

}