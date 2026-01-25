public function edit($user_id=0){
    global $app;

    $user = $app->model->users->find("id=?", [$user_id]);

    if($this->params && $user_id){

        if($this->data->id == $user_id){
            $this->params["role_id"] = $user->role_id;
            $this->params["status"] = $user->status;
            $this->params['admin'] = 1;
        }else{
            $this->params['admin'] = $this->params['role_id'] ? 1 : 0;
        }

        if($this->params['password']){
            $this->params['password'] = password_hash($this->params['password'].$app->config->app->encryption_token, PASSWORD_DEFAULT);
        }else{
            $this->params['password'] = $user->password;
        }

        if($this->params['status'] != 2){
            $this->params['reason_blocking_code'] = null;
            $this->params['time_expiration_blocking'] = null;
        }

        if(!$this->params['manager_image']){
            $this->params['avatar'] = $app->image->generateAvatar($this->params['name'].' '.$this->params['surname']);
        }else{
            $this->params['avatar'] = $this->params["manager_image"];
        }

        $app->model->users->update(["name"=>$this->params['name'], "surname"=>$this->params['surname'], "email"=>$this->params['email'], "phone"=>$this->params['phone'], "password"=>$this->params['password'], "avatar"=>$this->params['avatar'] ?: null, "status"=>(int)$this->params['status'], "reason_blocking_code"=>$this->params['reason_blocking_code']?:null, "time_expiration_blocking"=>$this->params['time_blocking']?:null, "role_id"=>(int)$this->params['role_id'], "admin"=>$this->params['admin']], $user_id);

        if(!$this->params['admin']){
             $app->model->users_notify_list->delete("user_id=?", [$user_id]);
        }

        if($this->data->id != $user_id && !$this->getRole($this->params['role_id'])->chief){
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

        return ['status'=>true];

    }

}