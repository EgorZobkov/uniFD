public function changeStatusVerification()
{   

    if(!$this->user->setUserId($_POST['id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['status'] == 1){
        $this->model->users->update(["verification_status"=>1],$_POST['id']);
    }else{
        $this->model->users->update(["verification_status"=>0],$_POST['id']);
    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}