public function editBalance()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['action'])->status == false){
        $answer['action'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['amount'])->status == false){
        $answer['amount'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->component->transaction->manageUserBalance(["user_id"=>$_POST['user_id'], "amount"=>$_POST['amount'], "text"=>$_POST['text']], $_POST['action']);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("action_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}