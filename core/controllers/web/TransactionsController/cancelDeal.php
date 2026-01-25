public function cancelDeal()
{   

    if($this->validation->requiredField($_POST['reason'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_110e7382175b53f7dc9b5939d7eb1e0f")]);
    }else{
        $this->component->transaction->cancelDeal($_POST['order_id'], $this->user->data->id, $_POST["reason"]);
        return json_answer(["status"=>true]);
    }

}