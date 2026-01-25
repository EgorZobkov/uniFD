public function requestsClear()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->search_requests->truncate();

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}