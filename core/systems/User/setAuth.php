public function setAuth($user_id=0, $remember_me=null, $entry_point=null, $device_model=null){
    global $app;

    if($user_id){

        $token = generateHashString();

        $app->system->addAuth(["user_id"=>$user_id, "token"=>$token, "entry_point"=>$entry_point, "device_model"=>$device_model]);
        $app->system->addAuthSession(["user_id"=>$user_id, "device_model"=>$device_model]);

        if($this->dashboard){

            if($remember_me){
                _setcookie(["key"=>"dashboard-token-auth", "value"=>$token, "lifetime"=>$app->datetime->addDay(30)->getTime()]);
            }

            $app->session->set("dashboard-token-auth", $token);
            $app->session->delete("dashboard-login-attempts");

        }else{

            if($remember_me){
                _setcookie(["key"=>"token-auth", "value"=>$token, "lifetime"=>$app->datetime->addDay(30)->getTime()]);
            }

            $app->session->set("token-auth", $token);
            $app->session->delete("login-attempts");

        }

        return $token;

    }

}