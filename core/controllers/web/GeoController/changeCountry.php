public function changeCountry()
{   

    $result = $this->component->geo->outOptionsFavoritesCities($_POST['id']);

    return json_answer(["content"=>$result]);

}