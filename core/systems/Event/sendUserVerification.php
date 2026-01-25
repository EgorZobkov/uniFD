public function sendUserVerification($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_new_user_verification")->addWaiting();

}