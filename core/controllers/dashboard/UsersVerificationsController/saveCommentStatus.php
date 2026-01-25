public function saveCommentStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $user = $this->model->users->find("id=?", [$data->user_id]);

    if(!$user) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['reason_comment'])->status == false){
        $answer['reason_comment'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->users_verifications->update(["status"=>"rejected", "comment"=>$_POST['reason_comment']],$_POST['id']);

        $this->model->users->update(["verification_status"=>0],$data->user_id);

        $this->storage->clearAttachFiles(_json_decode($data->media));

        $this->event->changeStatusUserVerification(["user_id"=>$data->user_id, "status"=>"rejected", "text"=>$_POST['reason_comment']]);

        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}