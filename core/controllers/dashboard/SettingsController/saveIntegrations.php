public function saveIntegrations(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($_POST["integration_map_service"]){
        if($this->validation->requiredField($_POST['integration_map_key'])->status == false){
            $answer["integration_map_key"] = $this->validation->error;
        }            
    }else{
        $_POST['integration_map_key'] = "";
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["integration_messenger_service"]?:null,"integration_messenger_service");
        $this->model->settings->update($_POST["integration_map_service"]?:null,"integration_map_service");
        $this->model->settings->update($_POST["integration_map_key"]?:null,"integration_map_key");
        $this->model->settings->update($_POST["integration_map_lang"]?:null,"integration_map_lang");
        $this->model->settings->update($_POST["integration_sms_service"] ?: null,"integration_sms_service");
        $this->model->settings->update($_POST["integration_sms_service_data"] ? encrypt(_json_encode($_POST["integration_sms_service_data"])) : null,"integration_sms_service_data");
        $this->model->settings->update($_POST["integration_payment_services_active"] ? _json_encode($_POST["integration_payment_services_active"]) : null,"integration_payment_services_active");
        $this->model->settings->update($_POST["integration_payment_service_secure_deal_active"],"integration_payment_service_secure_deal_active");
        $this->model->settings->update($_POST["integration_delivery_services_active"] ? _json_encode($_POST["integration_delivery_services_active"]) : null,"integration_delivery_services_active");

        $this->model->settings->update($_POST["auth_services_list"] ? _json_encode($_POST["auth_services_list"]) : null,"auth_services_list");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}