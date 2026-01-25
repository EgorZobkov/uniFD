public function totalAmount($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $amount = 0;

    if($item_ids){

        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

        }

    }else{

        if($user_id){
            $getItems = $app->model->cart->getAll("user_id=?", [$user_id]);
        }elseif($session_id){
            $getItems = $app->model->cart->getAll("session_id=?", [$session_id]);
        }

    }

    if($getItems){

        foreach ($getItems as $key => $value) {
            
            $ad = $app->model->ads_data->find("id=?", [$value["item_id"]]);

            if($ad){

                if(!$ad->not_limited){

                    if($value["count"] <= $ad->in_stock){
                        $amount += $ad->price * $value["count"];
                    }else{
                        $amount += $ad->price * $ad->in_stock;
                    }

                }else{
                    $amount += $ad->price * $value["count"];
                }

            }

        }

    }

    return $amount;

}