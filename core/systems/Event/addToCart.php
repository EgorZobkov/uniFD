public function addToCart($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["item_id"], "action_code"=>"add_to_cart"]);
}