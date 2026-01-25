 public function accessKey($key=null)
{

    if(isset($key)){
        $get = $this->model->auth_access_key->find('access_key=?', [$key]);
        if($get){
            $getUser = $this->model->users->find('id=? and admin=?', [$get->user_id, 1]);
            if($getUser){
                $token = generateHashString();
                $this->model->auth->insert(["user_id"=>$get->user_id, "token"=>$token, "time_expiration"=>$this->datetime->addDay(30)->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "geo"=>_json_encode(getGeolocation()), "entry_point"=>"key"]);
                $this->system->addAuthSession(["user_id"=>$get->user_id]);
                $this->session->set("dashboard-token-auth", $token);
                $this->router->goToRoute("dashboard");         
            }    
        }
    }

    $this->router->goToRoute("dashboard-auth");
    
}