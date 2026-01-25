public function minusCount($id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $count = 0;
    $price = 0;

    if($user_id){
        $get = $app->model->cart->find("user_id=? and id=?", [$user_id, $id]);
    }elseif($session_id){
        $get = $app->model->cart->find("session_id=? and id=?", [$session_id, $id]);
    }

    if($get){

        $count = $get->count;

        $ad = $app->model->ads_data->find("id=?", [$get->item_id]);

        if($ad){

            if($count > 1){

                $count = $count-1;

                if(!$ad->not_limited){

                    if($count > $ad->in_stock){
                        $count = $ad->in_stock;
                    }

                }

            }

            $price = $ad->price * $count;

        }else{
            return (object)["count"=>0, "price"=>0];
        }

        $app->model->cart->update(["count"=>$count], $get->id);

    }

    return (object)["count"=>$count, "price"=>$price];
    
}