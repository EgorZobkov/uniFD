public function multiExtend()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->ads->extendMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', translate("tr_16491016e0261108a14a0c1810e73c8c"));

    return json_answer(["status"=>true]);
}