public function paymentScoreAdd()
{

    $answer = [];

    if($this->model->users_payment_data->count("user_id=?", [$this->user->data->id]) >= 10){
        return json_answer(["status"=>false, "answer"=>translate("tr_7efb5c10f6ad317a2378e3d8edce624c")]);
    }

    if($this->validation->requiredField($_POST['score'])->status){

        $result = $this->component->profile->addPaymentScore($this->user->data->id, $_POST['score']);

        return json_answer($result);

    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_528a67adc943ea4fa07bf40c87be8294")]);
    }

}