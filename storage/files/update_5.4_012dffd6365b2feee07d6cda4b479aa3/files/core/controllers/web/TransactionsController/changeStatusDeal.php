public function changeStatusDeal()
{   

    $result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, $_POST["status"]);

    return json_answer($result);

}