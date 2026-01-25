public function addToFavorite($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["user_id"], "item_id"=>$data["ad_id"], "action_code"=>"add_to_favorite"]);

}