public function sendCodeVerifyContact($contact=[], $session_id=null){
    global $app;

    $result = [];

    if(!$session_id){
        $session_id = $app->session->get("user-session-id");
    }

    if(!$session_id && !getIp()){
        return ["status"=>false, "answer"=>translate("tr_eaf72927132caf9363e1382e59040976")];
    }

    $getCountSend = $app->model->users_waiting_verify_code->count("session_id=? or ip=?", [$session_id,getIp()]);

    if($getCountSend >= $app->settings->system_verify_attempts_count){

        $lastTime = $app->model->users_waiting_verify_code->sort("time_create desc")->find("session_id=? or ip=?", [$session_id,getIp()]);
        $time = strtotime($lastTime->time_create) + $app->settings->system_verify_block_time;

        if(time() >= $time){
            $app->model->users_waiting_verify_code->delete("session_id=? or ip=?", [$session_id,getIp()]);
        }else{
            return ["status"=>false, "answer"=>translate("tr_c864c3ee198870d8e76c354ffc383454") . ' ' . $app->datetime->outRemainedTime(time(), $time)];
        }
 
    }

    $code = generateNumberCode($app->settings->confirmation_length_code);

    if($contact["email"]){

        $result = $app->notify->params(["code"=>$code, "text"=>$code, "session_id"=>$session_id])->code("confirm_email")->to($contact["email"])->sendVerifyCode();

        return $result; 

    }elseif($contact["phone"]){

        $result = $app->notify->params(["code"=>$code, "text"=>$code, "session_id"=>$session_id])->to($contact["phone"])->sendVerifyCode();

        return $result; 

    }

    return $result; 

}