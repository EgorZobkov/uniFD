public function disputeClose()
{   

    $result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, "completed_order");

    return json_answer($result);

}