public function createUser($data = []){
    global $app;

    $app->component->chat->sendAction("system_registration", ["whom_user_id"=>$data["user_id"]], false);
    $app->component->profile->bonus($data["user_id"]);
    $app->component->profile->fixReferral($data["user_id"]);
    $app->notify->params((array)$data)->code("system_new_users")->addWaiting();

}