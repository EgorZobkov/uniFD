public function getCartItems($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $items = [];

    if($item_ids){

        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->sort("id desc")->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->sort("id desc")->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

        }

    }else{

        if($user_id){
            $getItems = $app->model->cart->sort("id desc")->getAll("user_id=?", [$user_id]);
        }elseif($session_id){
            $getItems = $app->model->cart->sort("id desc")->getAll("session_id=?", [$session_id]);
        }

    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            
            $ad = $app->component->ads->getAd($value["item_id"]);

            $items[$ad->user_id][] = (object)["id"=>$value["id"], "count"=>$value["count"], "item"=>$ad];

        }

    }

    return $items;

}