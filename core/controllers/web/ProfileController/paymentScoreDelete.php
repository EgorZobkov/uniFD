public function paymentScoreDelete()
{

    $card = $this->model->users_payment_data->find("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($card){

        $this->model->users_payment_data->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

        $data = $this->model->users_payment_data->sort("id desc")->find("user_id=?", [$this->user->data->id]);
       
        if($data){
            $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$this->user->data->id, $data->id]]);
        }

        if($card->card_id){
            $this->component->transaction->paymentCardDelete($this->user->data->id, $card->card_id);
        }

    }

    return json_answer(["status"=>true]);

}