public function initAuthorization($user=[], $remember_me=false, $entry_point=null, $device_model=null){
    global $app;

    if($user){

        $token = $this->setAuth($user->id,$remember_me ? true : false, $entry_point, $device_model);
        $app->event->authorizationUser($user); 

        if($app->session->get("ad-create-save")){
            $result = $app->component->ads->publication($app->session->getOnce("ad-create-save"),$user->id);
            return (object)["route"=>$app->component->ads->detectRoute($result), "user_id"=>$user->id, "token"=>$token];
        }

        return (object)["route"=>$app->router->getRoute("profile", [$user->alias]), "user_id"=>$user->id, "token"=>$token];

    }

}