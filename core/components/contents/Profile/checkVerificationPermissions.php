public function checkVerificationPermissions($user_id=0, $code=null){
    global $app;

    if($app->settings->verification_users_status){

        $user = $app->model->users->findById($user_id);

        if($user->verification_status){
            return true;
        }else{
            if(compareValues($app->settings->verification_users_permissions,$code)){
                return false;
            }else{
                return true;
            }
        }

    }

    return true;

}