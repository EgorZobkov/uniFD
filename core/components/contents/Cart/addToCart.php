 public function addToCart($item_id=0, $count=1, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    $ad = $app->component->ads->getAd($item_id);

    if(!$ad || $ad->delete){
        return "error";
    }

    if(!$app->component->ads->hasAddToCart($ad)){
        return "error";
    }

    if(!$app->component->ads->checkAvailable($item_id)){
        return "not_available";
    }

    if(!$this->checkInCart($item_id, $user_id)){
        $app->model->cart->insert(["user_id"=>(int)$user_id, "whom_user_id"=>(int)$ad->user_id, "item_id"=>$item_id, "count"=>$count, "time_create"=>$app->datetime->getDate(), "session_id"=>$session_id]);
        if($user_id){
            $app->event->addToCart(["from_user_id"=>$user_id, "item_id"=>$item_id, "whom_user_id"=>$ad->user_id]);
        }
    }

    return "added";

}