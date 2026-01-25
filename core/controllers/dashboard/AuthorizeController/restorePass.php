public function restorePass()
{

    $answer = [];

    if($this->validation->isEmail($_POST['login'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->session->getInt("dashboard-login-forgot-attempts") >= 3){
        return json_answer(["status"=>false, "captcha"=>true]);
        exit;
    }

    if(empty($answer)){
        $getUser = $this->model->users->find('email=? and admin=?', [$_POST['login'], 1]);
        if($getUser){

            if($getUser->status == 2){

                if($getUser->time_expiration_blocking){
                    $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". ". translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }else{
                    $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30")." ".$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }

                return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
            }

            $newPass =  generateCode(20);
            $hashPass = password_hash($newPass.$this->config->app->encryption_token, PASSWORD_DEFAULT);

            $this->model->users->update(["password"=>$hashPass], $getUser->id);

            $this->notify->params(["user_name"=>$getUser->name, "user_email"=>$getUser->email, "password"=>$newPass])->code("system_auth_reset_password")->to($getUser->email)->sendEmail();

            $this->session->setNotifyDashboard("success", translate("tr_a15aa14c5d021535af27fe5eb11b932c"));
            $this->session->set("dashboard-login-forgot-attempts", $this->session->getInt("dashboard-login-forgot-attempts")+1);

            return json_answer(["status"=>true, "route"=>$this->router->getRoute("dashboard-auth")]);

        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_a7518766bd95f2ba00c1beff04eb892f")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>$answer]);
    }

}