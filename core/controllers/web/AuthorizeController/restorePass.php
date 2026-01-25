public function restorePass()
{

    $answer = [];

    if($this->validation->requiredField($_POST['forgot_login'])->status == false){
        $answer["forgot_login"] = $this->validation->error;
    }else{

        $login = $this->validation->correctLogin($_POST['forgot_login']);

        if($login->status == false){
            $answer["forgot_login"] = $login->answer;
        }

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

            if($_POST['step'] == "input"){

                if($this->session->getInt("login-forgot-attempts") >= $this->settings->system_captcha_attempts_count && $this->settings->system_captcha_status){
                    return json_answer(["status"=>false, "captcha"=>true, "captcha_id"=>"login-forgot-attempts"]);
                }

                if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                    $this->session->set("login-forgot-attempts", $this->session->getInt("login-forgot-attempts")+1);

                    if($login->phone){

                        if($this->settings->phone_confirmation_status){

                            $result = $this->system->sendCodeVerifyContact(["phone"=>$login->phone]);

                            if($result["status"] == true){

                                if($result["call_phone"]){
                                    return json_answer(["status"=>false, "step"=>"check_verify", "call_phone"=>$result["call_phone"], "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-forgot.tpl')]); 
                                }else{
                                    return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-forgot.tpl')]);
                                }

                            }else{
                                return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                            }      

                        }                     

                    }elseif($login->email){

                        if($this->settings->email_confirmation_status){

                            $result = $this->system->sendCodeVerifyContact(["email"=>$login->email]);

                            if($result["status"] == true){
                                return json_answer(["status"=>false, "step"=>"check_verify", "content"=>$this->view->setParamsComponent(["data"=>(object)["phone"=>$login->phone, "email"=>$login->email]])->includeComponent('verification-forgot.tpl')]);
                            }else{
                                return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                            }

                        }

                    }

                }

                return json_answer(["status"=>false, "step"=>"new_pass"]);

            }elseif($_POST['step'] == "check_verify"){

                if($this->validation->requiredField($_POST['forgot_verify_code'])->status == false){
                    $answer["forgot_verify_code"] = $this->validation->error;
                }else{
                    if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['forgot_verify_code'])){
                        return json_answer(["status"=>false, "step"=>"new_pass"]);
                    }else{
                        $answer["forgot_verify_code"] = translate("tr_cf00880e485702e039ca4b00b87c5952");
                    }
                }

                return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"check_verify"]);

            }elseif($_POST['step'] == "new_pass"){

                if($this->validation->correctPassword($_POST['forgot_password'])->status == false){
                   $answer["forgot_password"] = $this->validation->error;
                }

                if(empty($answer)){

                    if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                       if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['forgot_verify_code'])){

                           $this->model->users->update(["password"=>password_hash($_POST['forgot_password'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $getUser->id);

                           $result = $this->user->initAuthorization($getUser, $_POST['remember_me'], "web");

                           $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);
                        
                           return json_answer(["status"=>true, "route"=>$result->route]);
                           
                       }else{
                           return json_answer(["status"=>false, "step"=>"input"]);
                       }

                    }else{

                       $this->model->users->update(["password"=>password_hash($_POST['forgot_password'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $getUser->id);

                       $result = $this->user->initAuthorization($getUser, $_POST['remember_me'], "web");

                       $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);
                    
                       return json_answer(["status"=>true, "route"=>$result->route]);

                    }

                }

                return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer, "step"=>"new_pass"]);

            }

        }else{
            return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>["forgot_login"=>translate("tr_a7518766bd95f2ba00c1beff04eb892f")]]);
        }

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}