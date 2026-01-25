public function verificationAuth($token=null, $user_id=0){
    global $app;

    if(!$token || !$user_id){
        return false;
    }

    $get = $app->model->auth->find('token=? and user_id=?', [$token, $user_id]);
    if($get){

        if($get->time_expiration == null || strtotime($get->time_expiration) > $app->datetime->getTime()){

            $data = $app->user->getData($get->user_id);

            if($data && !$data->delete && $data->status == 1){

                return true;

            }

        }

    }

    return false;
}