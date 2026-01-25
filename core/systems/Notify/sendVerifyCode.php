public function sendVerifyCode(){
    global $app;

    $answer = [];

    $params = $this->params;
    $code = $this->code;
    $user_id = $this->userId;
    $to = $this->to;

    if(isset($code)){

        $result = $this->sendEmail();

        if($result){
            $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
            $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_ceaa0361d1a7f798460364acecdf7437")];
        }else{
            $answer = ["status"=>false, "answer"=>translate("tr_eaf72927132caf9363e1382e59040976")];
        }

    }else{

        if($app->settings->phone_confirmation_service == "sms"){
            if($app->settings->integration_sms_service){

                $result = $app->addons->sms($app->settings->integration_sms_service)->send(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                if($result["status"] == true){

                    if($result["code"]){
                        $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                        $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_6977ca512793da7400e2dca8076b556f")];
                    }elseif($result["call_phone"]){
                        $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "service_internal_id"=>$result["service_internal_id"]?:null, "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                        $answer = ["status"=>true, "method"=>"call_phone", "call_phone"=>$result["call_phone"], "title"=>translate("tr_2fef908acd6aa0263c29833ab5ddb2ac")];
                    }

                }else{
                    $answer = ["status"=>false, "answer"=>translate("tr_ed7008d39fcad0962b27dde9a57a7287")];
                }

            }
        }elseif($app->settings->phone_confirmation_service == "messenger"){
            if($app->settings->integration_messenger_service){

                $result = $app->addons->messenger($app->settings->integration_messenger_service)->sendVerifyCode(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                if($result["status"] == true){

                    $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);

                    $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_cccb8532ba3d9c2d1249ba38187be66b")];

                }else{

                    if($app->settings->integration_sms_service){

                        $result = $app->addons->sms($app->settings->integration_sms_service)->send(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                        if($result["status"] == true){

                            if($result["code"]){
                                $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                                $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_6977ca512793da7400e2dca8076b556f")];
                            }elseif($result["call_phone"]){
                                $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "service_internal_id"=>$result["service_internal_id"]?:null, "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                                $answer = ["status"=>true, "method"=>"call_phone", "call_phone"=>$result["call_phone"], "title"=>translate("tr_2fef908acd6aa0263c29833ab5ddb2ac")];
                            }

                        }else{
                            $answer = ["status"=>false, "answer"=>translate("tr_ed7008d39fcad0962b27dde9a57a7287")];
                        }

                    }

                }

            }
        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    if($answer){
        return $answer;
    }else{
        return ["status"=>false, "answer"=>translate("tr_ef796f8fc3ce669548fb22bb06b53c17")];
    }
    
}