public function integrationsPaymentSaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->system_payment_services->update(["status"=>$_POST["status"], "name"=>$_POST["name"], "params"=>encrypt(_json_encode($_POST["params"])), "type_score_name"=>$_POST["type_score_name"], "title"=>$_POST["title"], "secure_deal_min_amount"=>$_POST["secure_deal_min_amount"], "secure_deal_max_amount"=>$_POST["secure_deal_max_amount"], "secure_deal_status"=>(int)$_POST["secure_deal_status"], "image"=>$_POST['manager_image'] ?: null, "secure_description"=>$_POST['secure_description'] ?: null], $_POST["id"]);

    if(!$this->component->settings->getActivePaymentServices()){
        $this->model->settings->update(null,"integration_payment_services_active");
    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}