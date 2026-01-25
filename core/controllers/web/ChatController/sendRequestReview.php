public function sendRequestReview()
{   

    $this->component->chat->sendAction("user_asks_review", ["from_user_id"=>$this->user->data->id, "dialogue_id"=>$_POST['dialogue_id']]);
    return json_answer(["status"=>true, "answer"=>translate("tr_1d352cc4cf47d86f6773d891190c9640")]);

}