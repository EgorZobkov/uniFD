public function sendCodeVerifyContact(){

    if($this->session->getInt("contact-attempts") >= $this->settings->system_captcha_attempts_count && $this->settings->system_captcha_status){
        return json_answer(["status"=>false, "captcha"=>true, "captcha_id"=>"contact-attempts"]);
    }

    if($this->settings->email_confirmation_status || $this->settings->phone_confirmation_status){

        $this->session->set("contact-attempts", $this->session->getInt("contact-attempts")+1);

        if($_POST["phone"]){
            if($this->validation->isPhone($_POST["phone"])->status == true){
                if($this->settings->phone_confirmation_status){
                    $result = $this->system->sendCodeVerifyContact(["phone"=>$this->clean->phone($_POST["phone"])]);
                    if($result["status"] == true){
                        if($result["call_phone"]){
                            return json_answer(["status"=>true, "call_phone"=>$result["call_phone"]]); 
                        }else{
                            return json_answer(["status"=>true]);
                        }
                    }else{
                        return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                    }
                }
            }else{
                return json_answer(["status"=>false, "answer"=>$this->validation->error]);
            }
        }

        if($_POST["email"]){
            if($this->validation->isEmail($_POST["email"])->status == true){
                if($this->settings->email_confirmation_status){
                    $result = $this->system->sendCodeVerifyContact(["email"=>$_POST["email"]]);
                    if($result["status"] == true){
                        return json_answer(["status"=>true]);
                    }else{
                        return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                    }
                }
            }else{
                return json_answer(["status"=>false, "answer"=>$this->validation->error]);
            }
        }

    }

    return json_answer(["status"=>true]);

}