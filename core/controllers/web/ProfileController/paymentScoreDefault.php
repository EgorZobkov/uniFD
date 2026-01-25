public function paymentScoreDefault()
{

    $this->model->users_payment_data->update(["default_status"=>0], ["user_id=?", [$this->user->data->id]]);

    $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$this->user->data->id, $_POST['id']]]);

    return json_answer(["status"=>true]);

}