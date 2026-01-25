public function searchAddress()
{   

    $result = $this->component->geo->searchAddress($_POST['query'], $_POST['city_id']);

    return json_answer(["answer"=>$result->items]);

}