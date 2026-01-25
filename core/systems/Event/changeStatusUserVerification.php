public function changeStatusUserVerification($data = []){
    global $app;

    if($data["status"] == "verified"){
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_verification_verified")->addWaiting();
    }else{
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_verification_rejected")->addWaiting();
    }

}