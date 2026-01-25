 public function confirm()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->complaints->update(["status"=>1],$_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}