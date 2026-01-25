public function fixClick($code=0, $user_id=0){
    global $app;

    $data = $app->model->advertising->find("uniq_code=? and status=?", [$code, 1]);

    if(!$data){
        return;
    }

    if($user_id){

        $check = $app->model->advertising_transitions->find("advertising_id=? and user_id=? and date(time_create)=?", [$data->id, $user_id, $app->datetime->format("Y-m-d")->getDate()]);
        
        if(!$check){
            $app->model->advertising_transitions->insert(["advertising_id"=>$data->id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif(getIp()){

        if(isBot(getUserAgent())){
            return;
        }

        $check = $app->model->advertising_transitions->find("ip=? and advertising_id=? and date(time_create)=?", [getIp(), $data->id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$check){
            $app->model->advertising_transitions->insert(["advertising_id"=>$data->id, "user_id"=>0, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}