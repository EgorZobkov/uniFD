public function changeStatus()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->changeStatus($_POST['id'],$_POST['status']);

    $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

    return json_answer(["status"=>true]);
}