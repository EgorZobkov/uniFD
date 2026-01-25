public function saveMailing()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['mailer_from_name'])->status == false){
        $answer['mailer_from_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['mailer_from_email'])->status == false){
        $answer['mailer_from_email'] = $this->validation->error;
    }

    if($_POST["mailer_service"] == "smtp"){
        if($this->validation->requiredField($_POST['mailer_smtp_host'])->status == false){
            $answer['mailer_smtp_host'] = $this->validation->error;
        }   
        if($this->validation->requiredField($_POST['mailer_smtp_port'])->status == false){
            $answer['mailer_smtp_port'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_username'])->status == false){
            $answer['mailer_smtp_username'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_password'])->status == false){
            $answer['mailer_smtp_password'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_secure'])->status == false){
            $answer['mailer_smtp_secure'] = $this->validation->error;
        }         
    }

    if(!$_POST["mailer_service"] || $_POST["mailer_service"] == "smtp"){
        $_POST["mailer_service_api_key"] = "";
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["mailer_service"],"mailer_service");
        $this->model->settings->update($_POST["mailer_service_api_key"] ? encrypt($_POST["mailer_service_api_key"]) : "","mailer_service_api_key");
        $this->model->settings->update($_POST["mailer_smtp_host"],"mailer_smtp_host");
        $this->model->settings->update($_POST["mailer_smtp_port"],"mailer_smtp_port");
        $this->model->settings->update($_POST["mailer_smtp_username"],"mailer_smtp_username");
        $this->model->settings->update($_POST["mailer_smtp_password"],"mailer_smtp_password");
        $this->model->settings->update($_POST["mailer_smtp_secure"],"mailer_smtp_secure");
        $this->model->settings->update($_POST["mailer_from_email"],"mailer_from_email");
        $this->model->settings->update($_POST["mailer_from_name"],"mailer_from_name");

        if($_POST["mailer_template_code"]){
            $getTpl = $this->notify->getActionCode($_POST["mailer_template_code"]);
            _file_put_contents($this->config->resource->mail->path.'/'.$getTpl->mail_tpl, urldecode($_POST["mailer_template_body"]));
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}