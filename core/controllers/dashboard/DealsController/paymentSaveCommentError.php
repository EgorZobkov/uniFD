public function paymentSaveCommentError()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['comment'])->status == false){
        $answer['comment'] = $this->validation->error;
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }else{

        $this->component->transaction->paymentSaveCommentError($_POST['id'], $_POST['comment'], $_POST['notify_recipient']);

        return json_answer(['status'=>true]);       

    }

}