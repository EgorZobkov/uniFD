public function fixStat($params=[]){
   global $app;

   if($params["session_id"]){

        $data = $app->model->mobile_stat->find("session_id=?", [$params["session_id"]]);

        if($data){
            $app->model->mobile_stat->update(["time_update"=>$app->datetime->getDate(), "user_id"=>$params["user_id"] ?: 0], ["session_id=?", [$params["session_id"]]]);
        }else{
            $app->model->mobile_stat->insert(["device_platform"=>$params["device_platform"] ?: null,"device_model"=>$params["device_model"] ?? null, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "ip"=>$params["ip"] ?: null, "user_id"=>$params["user_id"] ?: 0, "session_id"=>$params["session_id"]]);
        }

   }
   
}