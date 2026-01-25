public function checkInCart($item_id=0, $user_id=0){
    global $app;

    $item = [];
    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $item = $app->model->cart->find("user_id=? and item_id=?", [$user_id, $item_id]);

    }elseif($session_id){

        $item = $app->model->cart->find("session_id=? and item_id=?", [$session_id, $item_id]);

    }

    return $item;

}