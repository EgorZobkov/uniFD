public function paymentCardAdd()
{

    if(!$this->model->users_payment_data->find("user_id=? and type_score=?", [$this->user->data->id, "add_card"])){
        $result = $this->component->transaction->paymentCardAdd($this->user->data->id);
        return json_answer($result);
    }

    return json_answer(["status"=>false, "answer"=>translate("tr_876196cfa95230093e5c4f6e31459c4b")]);

}