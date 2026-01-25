 public function updateActiveStat($session_id=0){
    global $app;

    if($session_id){

         $app->model->mobile_stat->update(["time_update"=>$app->datetime->getDate()], ["session_id=?", [$session_id]]);

    }
    
 }