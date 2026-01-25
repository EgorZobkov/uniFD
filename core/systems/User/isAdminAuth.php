public function isAdminAuth($token=null){
    global $app;

    if(!$token){
        $token = $app->session->get("dashboard-token-auth");
    }

    if($token){

        $auth = $app->model->auth->find('token=?', [$token]);

        if($auth){

            if($auth->time_expiration == null || strtotime($auth->time_expiration) > $app->datetime->getTime()){

                $user = $app->model->users->find('id=?', [$auth->user_id]);
                if($user && !$user->delete){
                    if($user->status == 1){
                        return (object)["status"=>true, "user_id"=>$auth->user_id];
                    }
                }

            }

        }

    }

    return (object)["status"=>false];
    
}