 public function auth()
{

    $answer = [];

    if($this->session->getInt("login-attempts") >= $this->settings->system_captcha_attempts_count && $this->settings->system_captcha_status){ 
        return json_answer(["status"=>false, "captcha"=>true, "captcha_id"=>"login-attempts"]);
    }

    if($this->validation->requiredField($_POST['auth_login'])->status == false){
        $answer["auth_login"] = $this->validation->error;
    }else{

        $login = $this->validation->correctLogin($_POST['auth_login']);

        if($login->status == false){
            $answer["auth_login"] = $login->answer;
        }

    }

    if($this->settings->registration_authorization_view == "combined"){

        if(empty($answer)){

            if($login->email){
                $getUser = $this->model->users->find('email=?', [$login->email]);
            }else{
                $getUser = $this->model->users->find('phone=?', [$login->phone]);
            }
            
            if($getUser){

                if($getUser->status == 2){

                    if($getUser->time_expiration_blocking){
                        $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". " . translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . " " . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }else{
                        $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30").' '.$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }

                    return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
                }

                if($_POST["step"] == "input"){

                    return json_answer(["status"=>false, "step"=>"check_password", "welcome"=>translate("tr_66a2e20820c3e976765ccb17b1b7adca").", {$getUser->name}!"]);

                }elseif($_POST["step"] == "check_password"){
                   
                    if($this->validation->requiredField($_POST['auth_password'])->status == false){
                        $answer["auth_password"] = $this->validation->error;
                    }else{
                        if(password_verify($_POST["auth_password"].$this->config->app->encryption_token, $getUser->password)){

                            $result = $this->user->initAuthorization($getUser, $_POST['remember_me'], "web");

                            return json_answer(["status"=>true, "route"=>$result->route]);

                        }else{
                            $this->session->set("login-attempts", $this->session->getInt("login-attempts")+1);
                            $answer["auth_password"] = translate("tr_596914aef126f67cfa06701a04b45a44");
                        }
                    }

                    return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"check_password", "welcome"=>translate("tr_66a2e20820c3e976765ccb17b1b7adca").", {$getUser->name}!"]);

                }

                return json_answer(["status"=>false, "step"=>"input"]);

            }else{ 

                if($login->email){

                    if($this->validation->isAllowedEmail($login->email)->status == false){
                        $answer["auth_login"] = translate("tr_99d738d679cdadd3386402846380a0d0")." ".$this->validation->error;
                        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"input"]);
                    }

                }else{

                    if($this->validation->isAllowedPhone($login->phone)->status == false){
                        $answer["auth_login"] = translate("tr_0f70e0aaba5711f57ecd3f4a4cea93a2")." ".$this->validation->error;
                        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"input"]);
                    }

                } 

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
                                        return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-registration-combined.tpl')]);
                                    }      

                                }else{
                                    return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                                }

                            }else{
                                return json_answer(["status"=>false, "step"=>"registration_data"]);
                            }                     

                        }elseif($login->email){

                            if($this->settings->email_confirmation_status){

                                $result = $this->system->sendCodeVerifyContact(["email"=>$login->email]);

                                if($result["status"] == true){
                                    return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-registration-combined.tpl')]);
                                }else{
                                    return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                                }

                            }else{

                                return json_answer(["status"=>false, "step"=>"registration_data"]);

                            }

                        }

                    }else{
                        return json_answer(["status"=>false, "step"=>"registration_data"]);
                    }

                }elseif($_POST['step'] == "check_verify"){

                    if($this->validation->requiredField($_POST['verify_code'])->status == false){
                        $answer["verify_code"] = $this->validation->error;
                    }else{

                        if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['verify_code'])){
                            return json_answer(["status"=>false, "step"=>"registration_data"]);
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

                           $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);

                           return json_answer(["status"=>true, "route"=>$result->route]);

                        }

                    }

                    return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"registration_data"]);

                }

            }

        }else{

            return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"input"]);

        }

    }elseif($this->settings->registration_authorization_view == "separate"){

        if($this->validation->requiredField($_POST['auth_password'])->status == false){
            $answer["auth_password"] = $this->validation->error;
        }

        if(empty($answer)){

            if($login->email){
                $getUser = $this->model->users->find('email=?', [$login->email]);
            }else{
                $getUser = $this->model->users->find('phone=?', [$login->phone]);
            }

            if($getUser){

                if($getUser->status == 2){

                    if($getUser->time_expiration_blocking){
                        $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". " . translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . " " . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }else{
                        $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30").' '.$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }

                    return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
                }

                if(password_verify($_POST["auth_password"].$this->config->app->encryption_token, $getUser->password)){

                    $result = $this->user->initAuthorization($getUser, $_POST['remember_me'], "web");

                    return json_answer(["status"=>true, "route"=>$result->route]);

                }else{
                    $this->session->set("login-attempts", $this->session->getInt("login-attempts")+1);
                    return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>["auth_password"=>translate("tr_063a2b7c4f3d9fdf21b33aeb9919fd2c")]]);
                }

            }else{

                $this->session->set("login-attempts", $this->session->getInt("login-attempts")+1);
                return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>["auth_password"=>translate("tr_063a2b7c4f3d9fdf21b33aeb9919fd2c")]]);

            }

        }else{

            return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

        }

    }

}