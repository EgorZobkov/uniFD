public function checkVerifyContact($contact=[], $code=null, $session_id=null){
    global $app;

    if(!$app->settings->phone_confirmation_status && !$app->settings->email_confirmation_status){
        return true;
    }

    if(!$session_id){
        $session_id = $app->session->get("user-session-id");
    }

    if($contact["email"]){

        if($app->settings->email_confirmation_status){

            $data = $app->model->users_waiting_verify_code->find("session_id=? and code=? and contact=? order by id desc", [$session_id,$code,$contact["email"]]);

            if($data){
                return true;
            }

        }else{
            return true;
        }

    }elseif($contact["phone"]){

        if($app->settings->phone_confirmation_status){

            $data = $app->model->users_waiting_verify_code->find("session_id=? and contact=? order by id desc", [$session_id,$contact["phone"]]);

            if($data){
                if($data->status == 1){
                    return true;
                }elseif($code && $data->code == $code){
                    return true;
                }
            }

        }else{
            return true;
        }

    }

    return false;
 
}