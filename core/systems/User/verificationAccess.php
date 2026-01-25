public function verificationAccess($permission=null, $route_id=null){
    global $app;

    if(!isset($route_id)){
        $route_id = $app->router->currentRoute->route_id;
    }

    if($this->data->role->chief){
        return (object)["status"=>true];
    }

    if(isset($this->userId)){
        if($this->userId == $this->data->id){
            $this->userId = null;
            return (object)["status"=>true];
        }
        $this->userId = null;
    }

    if(isset($permission) && $route_id){

        $getPrivilege = $app->model->system_privileges->find('route_id=?', [$route_id]);

        if($getPrivilege){

            if($this->data->privileges){

                if(isset($this->data->privileges[$getPrivilege->id][$permission])){
                    return (object)["status"=>true];
                }

            }

        }

    }

    return (object)["status"=>false];

}