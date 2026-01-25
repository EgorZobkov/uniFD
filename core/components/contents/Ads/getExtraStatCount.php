public function getExtraStatCount($ad_id=0){
    global $app;

    $result = [];

    if($ad_id){

        $result["cart"] = $app->model->cart->count("item_id=?", [$ad_id]);
        $result["favorite"] = $app->model->users_favorites->count("ad_id=?", [$ad_id]);
        $result["view_contacts"] = $app->model->users_actions->count("item_id=? and action_code=?", [$ad_id, "view_ad_contacts"]);

    }

    return (object)$result;

}