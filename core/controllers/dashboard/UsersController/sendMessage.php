public function sendMessage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return $this->view->accessDenied();
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }        

    if(empty($answer)){

        $user = $this->model->users->find("id=?", [$_POST['user_id']]);

        if($user){
            $this->component->chat->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$_POST['user_id'], "text"=>$_POST['text'], "channel_id"=>1, "attach_files"=>null]);
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("action_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}