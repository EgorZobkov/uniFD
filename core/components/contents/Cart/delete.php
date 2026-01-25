public function delete($id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $app->model->cart->delete("user_id=? and id=?", [$user_id, $id]);

    }elseif($session_id){

        $app->model->cart->delete("session_id=? and id=?", [$session_id, $id]);

    }

}