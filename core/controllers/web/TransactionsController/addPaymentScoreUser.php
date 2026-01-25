public function addPaymentScoreUser()
{   

    if($this->validation->requiredField($_POST['score'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_d3d05547a7366b773ccc9138621d1d2b")]);
    }else{
        $result = $this->component->transaction->addPaymentScoreUser($_POST['order_id'], $this->user->data->id, $_POST["score"]);
        return json_answer($result);
    }

}