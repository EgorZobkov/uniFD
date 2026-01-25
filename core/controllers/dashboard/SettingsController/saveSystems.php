public function saveSystems(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if(!intval($_POST["confirmation_length_code"]) || intval($_POST["confirmation_length_code"]) > 100){
        $_POST["confirmation_length_code"] = 4;
    }

    if(!intval($_POST["system_captcha_attempts_count"])){
        $_POST["system_captcha_attempts_count"] = 2;
    }

    if(!intval($_POST["system_verify_attempts_count"])){
        $_POST["system_verify_attempts_count"] = 2;
    }

    if(!intval($_POST["system_verify_block_time"])){
        $_POST["system_verify_block_time"] = 90;
    }

    if($_POST["default_language"] != $this->settings->default_language){
        $this->component->translate->setMainIso($_POST["default_language"]);
    }

    $this->model->settings->update($_POST["default_language"],"default_language");
    $this->model->settings->update($_POST["system_timezone"],"system_timezone");
    $this->model->settings->update($_POST["system_default_currency"],"system_default_currency");
    $this->model->settings->update($_POST["system_extra_currency"] ? _json_encode($_POST["system_extra_currency"]) : null,"system_extra_currency");
    $this->model->settings->update($_POST["system_currency_position"],"system_currency_position");
    $this->model->settings->update($_POST["system_currency_spacing"],"system_currency_spacing");
    $this->model->settings->update($_POST["system_price_reduction_status"],"system_price_reduction_status");
    $this->model->settings->update($_POST["system_price_separator"],"system_price_separator");
    $this->model->settings->update($_POST["frontend_scripts"],"frontend_scripts");
    $this->model->settings->update($_POST["system_report_status"],"system_report_status");
    $this->model->settings->update($_POST["system_report_period"],"system_report_period");
    $this->model->settings->update($_POST["system_report_recipients_ids"] ? _json_encode($_POST["system_report_recipients_ids"]) : null,"system_report_recipients_ids");
    $this->model->settings->update($_POST["system_report_send_time"] ?: "23:59","system_report_send_time");
    $this->model->settings->update($_POST["system_report_send_if_zero"],"system_report_send_if_zero");
    $this->model->settings->update($_POST["geo_autodetect"],"geo_autodetect");
    $this->model->settings->update($_POST["system_captcha_status"],"system_captcha_status");
    $this->model->settings->update($_POST["confirmation_length_code"],"confirmation_length_code");
    $this->model->settings->update($_POST["multi_languages_status"],"multi_languages_status");
    $this->model->settings->update($_POST["phone_confirmation_status"],"phone_confirmation_status");
    $this->model->settings->update($_POST["phone_confirmation_service"],"phone_confirmation_service");
    $this->model->settings->update($_POST["email_confirmation_status"],"email_confirmation_status");
    $this->model->settings->update($_POST["allowed_templates_email_all_status"],"allowed_templates_email_all_status");
    $this->model->settings->update($_POST["allowed_templates_email"],"allowed_templates_email");
    $this->model->settings->update($_POST["allowed_templates_phone_all_status"],"allowed_templates_phone_all_status");
    $this->model->settings->update($_POST["allowed_templates_phone"] ? _json_encode($_POST["allowed_templates_phone"]) : null,"allowed_templates_phone");

    $this->model->settings->update(intval($_POST["system_captcha_attempts_count"]),"system_captcha_attempts_count");
    $this->model->settings->update(intval($_POST["system_verify_attempts_count"]),"system_verify_attempts_count");
    $this->model->settings->update(intval($_POST["system_verify_block_time"]),"system_verify_block_time");
    $this->model->settings->update($_POST["default_template_phone_iso"] ?: null,"default_template_phone_iso");

    if($_POST["system_measurement"]){
        $current_ids = [];
        if(is_array($_POST["system_measurement"])){
            foreach ($_POST["system_measurement"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                    if($action == "add"){
                        if(trim($value)){
                            $current_ids[] = $this->model->system_measurements->insert(["name"=>$value]);
                        }
                    }
                    if($action == "update"){
                        if(trim($value)){
                            $this->model->system_measurements->update(["name"=>$value], $id);
                            $current_ids[] = $id;
                        }
                    }
                }  
            }
            if($current_ids){
                $this->model->system_measurements->delete("id NOT IN(".implode(",", $current_ids).")");
            }
        }
    }else{
        $this->model->system_measurements->delete();
    }

    if($_POST["system_price_names"]){
        $current_ids = [];
        if(is_array($_POST["system_price_names"])){
            foreach ($_POST["system_price_names"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                    if($action == "add"){
                        if(trim($value)){
                            $current_ids[] = $this->model->system_price_names->insert(["name"=>$value]);
                        }
                    }
                    if($action == "update"){
                        if(trim($value)){
                            $this->model->system_price_names->update(["name"=>$value], $id);
                            $current_ids[] = $id;
                        }
                    }
                }  
            }
            if($current_ids){
                $this->model->system_price_names->delete("id NOT IN(".implode(",", $current_ids).")");
            }
        }
    }else{
        $this->model->system_price_names->delete();
    }

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}