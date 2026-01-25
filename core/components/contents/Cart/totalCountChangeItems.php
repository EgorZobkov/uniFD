public function totalCountChangeItems($user_id=0, $item_ids=[]){
    global $app;

    $session_id = $app->session->get("user-session-id");
    $count = 0;

    if($item_ids){
        if(is_array($item_ids)){

            if($user_id){
                $getItems = $app->model->cart->getAll("user_id=? and id IN(".implode(",", $item_ids).")", [$user_id]);
            }elseif($session_id){
                $getItems = $app->model->cart->getAll("session_id=? and id IN(".implode(",", $item_ids).")", [$session_id]);
            }

            if($getItems){

                foreach ($getItems as $key => $value) {
                    
                    $ad = $app->model->ads_data->find("id=?", [$value["item_id"]]);

                    if($ad){

                        if(!$ad->not_limited){

                            if($ad->in_stock){

                                if($value["count"] <= $ad->in_stock){
                                    $count += $value["count"];
                                }else{
                                    $count += $ad->in_stock;
                                }

                            }

                        }else{
                            $count += $value["count"];
                        }

                    }

                }

            }

        }
    }

    return $count;

}