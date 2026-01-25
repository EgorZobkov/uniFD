public function count($user_id=0){
    global $app;

    $count = 0;
    $session_id = $app->session->get("user-session-id");

    if($user_id){

        $getItems = $app->model->cart->sort("id desc")->getAll("user_id=?", [$user_id]);

    }elseif($session_id){

        $getItems = $app->model->cart->sort("id desc")->getAll("session_id=?", [$session_id]);

    }

    if($getItems){
        foreach ($getItems as $key => $value) {
            if($app->model->ads_data->find("id=?", [$value["item_id"]])){
                $count = $count + $value["count"];
            }
        }
    }

    return $count;

}