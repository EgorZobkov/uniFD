 public function changeStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users_verifications->find("id=?", [$_POST['id']]);

    $user = $this->model->users->find("id=?", [$data->user_id]);

    if(!$user) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    $this->model->users_verifications->update(["status"=>$_POST['status'], "comment"=>null],$_POST['id']);

    if($_POST['status'] == "verified"){
        $this->model->users->update(["verification_status"=>1],$data->user_id);
        $this->storage->clearAttachFiles(_json_decode($data->media));
    }else{
        $this->model->users->update(["verification_status"=>0],$data->user_id);
    }

    $this->event->changeStatusUserVerification(["user_id"=>$data->user_id, "status"=>$_POST['status']]);

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}