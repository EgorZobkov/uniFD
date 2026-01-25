public function auth()
{

    $answer = [];

    if($this->validation->isEmail($_POST['login'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->validation->isPassword($_POST['password'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->session->getInt("dashboard-login-attempts") >= 3){
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

            if(password_verify($_POST["password"].$this->config->app->encryption_token, $getUser->password)){

                $this->user->dashboard(true)->setAuth($getUser->id,$_POST['remember_me'] ? true : false, "web");

                if($this->session->get("dashboard-route-end-point")){
                    $route = $this->session->get("dashboard-route-end-point");
                }else{
                    $route = $this->router->getRoute("dashboard");
                }

                return json_answer(["status"=>true, "route"=> $route]);

            }else{
                $this->session->set("dashboard-login-attempts", $this->session->getInt("dashboard-login-attempts")+1);
                return json_answer(["status"=>false, "answer"=>translate("tr_fb455705f2417620bd45ac48d857f189")]);
            }

        }else{ 
            $this->session->set("dashboard-login-attempts", $this->session->getInt("dashboard-login-attempts")+1);
            return json_answer(["status"=>false, "answer"=>translate("tr_fb455705f2417620bd45ac48d857f189")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>$answer]);
    }

}