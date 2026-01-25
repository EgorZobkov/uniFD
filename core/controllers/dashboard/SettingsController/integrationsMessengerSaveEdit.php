public function integrationsMessengerSaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->system_messenger_services->find("id=?", [$_POST["id"]]);

    if($data){

        $this->model->system_messenger_services->update(["name"=>$_POST['name'] ?: null, "params"=>encrypt(_json_encode($_POST["params"])), "image"=>$_POST['manager_image'] ?: null], $_POST["id"]);

        $this->addons->messenger($_POST["id"])->trigger();

    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}