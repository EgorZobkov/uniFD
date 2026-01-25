public function registration()
{

    $answer = [];

    if($this->session->getInt("login-attempts") >= $this->settings->system_captcha_attempts_count && $this->settings->system_captcha_status){
        return json_answer(["status"=>false, "captcha"=>true, "captcha_id"=>"login-attempts"]);
    }

    if($this->validation->requiredField($_POST['registration_login'])->status == false){
        $answer["registration_login"] = $this->validation->error;
    }else{

        $login = $this->validation->correctLogin($_POST['registration_login']);

        if($login->status == false){
            $answer["registration_login"] = $login->answer;
        }else{

            if($login->email){

                $check = $this->model->users->find("email=?", [$login->email]);
                if($check){
                    $answer['registration_login'] = translate("tr_39a86c7c7e022ce4a7987d7dc283a024");
                }else{

                    if($this->validation->isAllowedEmail($login->email)->status == false){
                        $answer["registration_login"] = translate("tr_99d738d679cdadd3386402846380a0d0")." ".$this->validation->error;
                    }

                }

            }else{

                $check = $this->model->users->find("phone=?", [$login->phone]);
                if($check){
                    $answer['registration_login'] = translate("tr_c73c35b22a20f6f50528d200d258f805");
                }else{

                    if($this->validation->isAllowedPhone($login->phone)->status == false){
                        $answer["registration_login"] = translate("tr_0f70e0aaba5711f57ecd3f4a4cea93a2")." ".$this->validation->error;
                    }

                }

            }

        }

    }

    if($this->validation->requiredField($_POST['registration_name'])->status == false){
        $answer["registration_name"] = $this->validation->error;
    }

    if($this->validation->correctPassword($_POST['registration_password'])->status == false){
        $answer["registration_password"] = $this->validation->error;
    }

    if(empty($answer)){

        if($_POST['step'] == "input"){

            if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                $this->session->set("login-attempts", $this->session->getInt("login-attempts")+1);

                if($login->phone){

                    if($this->settings->phone_confirmation_status){

                        $result = $this->system->sendCodeVerifyContact(["phone"=>$login->phone]);
                        
                        if($result["status"] == true){

                            if($result["call_phone"]){
                                return json_answer(["status"=>false, "step"=>"check_verify", "call_phone"=>$result["call_phone"], "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-registration-combined.tpl')]); 
                            }else{
                                return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-registration-separate.tpl')]);
                            }

                        }else{
                            return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                        }                              

                    }                     

                }elseif($login->email){

                    if($this->settings->email_confirmation_status){

                        $result = $this->system->sendCodeVerifyContact(["email"=>$login->email]);

                        if($result["status"] == true){
                            return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-registration-separate.tpl')]);
                        }else{
                            return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                        }

                    }

                }

            }

            $result = $this->user->initRegistration(["name"=>$_POST['registration_name'], "email"=>$login->email, "phone"=>$login->phone, "status"=>1, "password"=>$_POST['registration_password']], "web");

            return json_answer(["status"=>true, "route"=>$result->route]);

        }elseif($_POST['step'] == "check_verify"){

            if($this->validation->requiredField($_POST['verify_code'])->status == false){
                $answer["verify_code"] = $this->validation->error;
            }else{

                if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['verify_code'])){
                    $result = $this->user->initRegistration(["name"=>$_POST['registration_name'], "email"=>$login->email, "phone"=>$login->phone, "status"=>1, "password"=>$_POST['registration_password']], "web");
                    return json_answer(["status"=>true, "route"=>$result->route]);
                }else{
                    $answer["verify_code"] = translate("tr_cf00880e485702e039ca4b00b87c5952");
                    $this->session->set("login-attempts", $this->session->getInt("login-attempts")+1);
                }

            }

            return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"check_verify"]);

        }elseif($_POST['step'] == "registration_data"){

            if($this->validation->requiredField($_POST['registration_name'])->status == false){
               $answer["registration_name"] = $this->validation->error;
            }

            if($this->validation->correctPassword($_POST['registration_password'])->status == false){
               $answer["registration_password"] = $this->validation->error;
            }

            if(empty($answer)){

                $params = ["name"=>$_POST['registration_name'], "email"=>$login->email, "phone"=>$login->phone, "status"=>1, "password"=>$_POST['registration_password']];

                if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                    if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['verify_code'])){

                        $result = $this->user->initRegistration($params, "web");

                        $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);

                        return json_answer(["status"=>true, "route"=>$result->route]);
                       
                    }else{
                        return json_answer(["status"=>false, "step"=>"input"]);
                    }

                }else{

                   $result = $this->user->initRegistration($params, "web");

                   return json_answer(["status"=>true, "route"=>$result->route]);

                }

            }

            return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"input"]);

        }

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"input"]);

    }


}