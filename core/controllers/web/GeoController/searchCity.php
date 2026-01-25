public function searchCity()
{   

    $result = $this->component->geo->searchCity($_POST['query']);

    return json_answer(["answer"=>$result->items]);

}