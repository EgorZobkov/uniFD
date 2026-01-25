public function add(){
    global $app;

    if($this->params){

        $this->params['time_create'] = $this->params['time_create']?:$app->datetime->getDate();
        $this->params['password'] = isset($this->params['password']) ? password_hash($this->params['password'].$app->config->app->encryption_token, PASSWORD_DEFAULT) : null;

        if($this->params['status'] != 2){
            $this->params['reason_blocking_code'] = null;
            $this->params['time_expiration_blocking'] = null;
        }

        $this->params['admin'] = $this->params['role_id'] ? 1 : 0;

        if(!$this->params['manager_image']){
            $this->params['avatar'] = $app->image->generateAvatar($this->params['name'].' '.$this->params['surname']);
        }else{
            $this->params['avatar'] = $this->params["manager_image"];
        }

        $user_id = $app->model->users->insert(["time_create"=>$this->params['time_create'], "name"=>$this->params['name'], "surname"=>$this->params['surname'], "email"=>$this->params['email']?:null, "phone"=>$this->params['phone']?:null, "password"=>$this->params['password'], "avatar"=>$this->params['avatar']?:null, "status"=>(int)$this->params['status'], "reason_blocking_code"=>$this->params['reason_blocking_code']?:null, "time_expiration_blocking"=>$this->params['time_blocking'], "role_id"=>(int)$this->params['role_id'], "notifications_method"=>"email", "admin"=>$this->params['admin'], "alias"=>generateCode(30), "uniq_hash"=>generateHashString(), "notifications"=>'{"chat":"1","expiration_ads":"1","expiration_tariff":"1","add_to_favorite":"1","view_ad_contacts":"1"}', "import_id"=>$this->params['import_id']?:0]);

        if($user_id && $this->params['admin']){

            if(!$this->getRole($this->params['role_id'])->chief){
                if($this->params['privileges']){
                    $app->model->users_privileges->delete("user_id=?", [$user_id]);
                    foreach ($this->params['privileges'] as $privilege_id => $nested) {
                        $privilege = $app->model->system_privileges->find("id=?", [$privilege_id]);
                        if($privilege){
                            foreach ($nested as $privilege_name => $value) {
                                $app->model->users_privileges->insert(["user_id"=>$user_id, "privilege_id"=>$privilege_id, "privilege_name"=>$privilege_name, "route_id"=>$privilege->route_id]); 
                            }
                        }
                    }
                }
            }

        }

        return $user_id;

    }

    return null;
}