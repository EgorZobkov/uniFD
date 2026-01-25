public function oauth($network){

    $result = [];

    if(!$this->settings->auth_services_list){
        return;
    }

    $data = $this->model->system_oauth_services->find("id IN(".implode(",", $this->settings->auth_services_list).") and alias=?", [$network]);

    if($data){
        $instance = $this->addons->oauth($data->alias);
        $result = $instance->callback($_REQUEST);
    }

    if($result){

        $login = $result["email"] ?: $result["phone"];

        if($login){

           $getUser = $this->model->users->find('email=? or phone=?', [$login, $login]);

           if($getUser){

                if($getUser->status == 2){
                    $this->router->goToRoute("auth");
                }

                $result = $this->user->initAuthorization($getUser, false, "web");

                $this->router->goToUrl($result->route);  

           }else{

                $result = $this->user->initRegistration(["name"=>$result["name"], "surname"=>$result["surname"], "email"=>$result["email"]?:null, "phone"=>$result["phone"]?:null, "status"=>1, "avatar"=>$result["photo"]], "web");

                $this->router->goToUrl($result->route);

           }

        }else{
           $this->router->goToRoute("auth");
        }

    }else{
        $this->router->goToRoute("auth");
    }

}