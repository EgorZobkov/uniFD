public function reviewData($value=[]){
    global $app;

    $user = $app->model->users->find("id=?", [$value['from_user_id']]);
    $ad = $app->component->ads->getAd($value["item_id"]);

    return [
        "id" => $value['id'],
        "rating" => $value['rating'],
        "item_title" => $ad->title,
        "media"=>_json_decode($value['media']),
        "text" => html_entity_decode($value['text']),
        "from_user" => [
            "display_name"=>$app->user->name($user),
            "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
        ], 
    ];

}