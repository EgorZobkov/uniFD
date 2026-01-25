public function users(){

    $this->model->traffic_realtime->delete("unix_timestamp(now()) > unix_timestamp(time_update) + 600");

    $getUsers = $this->model->users->sort("id asc limit 500")->getAll("time_expiration_blocking is not null and now() >= time_expiration_blocking and status=?", [2]);
    
    if($getUsers){
        foreach ($getUsers as $value) {

            $this->model->users->update(["time_expiration_blocking"=>null, "status"=>1], $value["id"]);
            
        }
    }

}