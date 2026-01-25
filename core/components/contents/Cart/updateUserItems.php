public function updateUserItems(){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($app->user->isAuth()){
        if($session_id){
            $app->model->cart->update(["user_id"=>$app->user->data->id], ["session_id=?", [$session_id]]);
            $app->model->cart->delete("user_id=? and whom_user_id=?", [$app->user->data->id, $app->user->data->id]);
        }
    }

}