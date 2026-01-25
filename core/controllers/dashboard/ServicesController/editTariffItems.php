public function editTariffItems(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['tariff_items']){

        foreach ($_POST['tariff_items'] as $id => $value) {
            
            $this->model->users_tariffs_items->update(["name"=>$value["name"], "text"=>$value["text"]], $id);

        }

    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}