public function isAdminAuthAndCheckAccess($permission=null, $route_id=null){
    global $app;

    $auth = $this->isAdminAuth();

    if($auth->status){
        $user = $app->model->users->find('id=?', [$auth->user_id]);
    }

    if(!$user || $user->delete){
        return (object)["status"=>false];
    }

    if($user->role_id){
        $user->role = $this->getRole($user->role_id);
        $user->privileges = $this->getPrivileges($auth->user_id);
    }

    if($user->role->chief){
        return (object)["status"=>true];
    }

    if(isset($permission) && $route_id){

        $getPrivilege = $app->model->system_privileges->find('route_id=?', [$route_id]);

        if($getPrivilege){

            if($user->privileges){

                if(isset($user->privileges[$getPrivilege->id][$permission])){
                    return (object)["status"=>true];
                }

            }

        }

    }

    return (object)["status"=>false];

}