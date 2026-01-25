public function multiDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->deleteMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', translate("tr_6f9811271936b72e0d9c1f08d2dca0f4"));

    return json_answer(["status"=>true]);
}