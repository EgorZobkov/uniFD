public function loadStory()
{   

    $result = $this->component->stories->loadInDashboard($this->request->get('id'));
    return json_answer(["content"=>$result]);

}