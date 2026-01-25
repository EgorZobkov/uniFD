public function search(){

    $result = $this->system->searchCombined($_POST["query"]);
    return json_answer($result);

}