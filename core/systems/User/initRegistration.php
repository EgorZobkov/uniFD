public function initRegistration($params=[], $entry_point=null, $device_model=null){
    global $app;

    if($params){

        $user_id = $this->params($params)->add();

        $token = $this->setAuth($user_id, false, $entry_point, $device_model);

        $user = $app->model->users->find('id=?', [$user_id]);

        $app->event->createUser(["user_id"=>$user->id]);

        if($app->session->get("ad-create-save")){
            $result = $app->component->ads->publication($app->session->getOnce("ad-create-save"),$user->id);
            return (object)["route"=>$app->component->ads->detectRoute($result), "user_id"=>$user_id, "token"=>$token];
        }

        if($app->settings->registration_bonus_status){
            return (object)["route"=>$app->router->getRoute("profile", [$user->alias])."#bonus", "user_id"=>$user_id, "token"=>$token];
        }else{
            return (object)["route"=>$app->router->getRoute("profile", [$user->alias]), "user_id"=>$user_id, "token"=>$token];
        }

    }

}