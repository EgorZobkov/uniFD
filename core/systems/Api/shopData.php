public function shopData($value=[]){
    global $app;

    $ads_images = [];

    $user = $app->model->users->find("id=?", [$value["user_id"]]);

    $countAds = $app->model->ads_data->count("user_id=? and status=?", [$value["user_id"], 1]);
    $getSliceAds = $app->model->ads_data->getAll("user_id=? and status=? order by id desc limit 30", [$value["user_id"], 1]);

    if($getSliceAds){
        shuffle($getSliceAds);
        foreach ($getSliceAds as $ad) {
            $array_images = $app->component->ads->getMedia($ad["media"]);
            $ads_images[] = $array_images->images->first;
        }
    }

    return [
        "id" => $value['id'],
        "title" => html_entity_decode($value['title']),
        "text" => html_entity_decode($value['text']),
        "logo" => $app->storage->name($value["image"])->host(true)->get(),
        "count_ads" => $countAds .' '.endingWord($getCountAds, translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d")),
        "count_ads_int" => $countAds,
        "ads_images" => $ads_images ?: null,
        "user" => [
            "id"=>$value["user_id"],
            "total_rating"=>$user->total_rating ?: '0',
            "total_reviews"=>$user->total_reviews ?: '0',
            "show_rating"=>$user->total_rating ? true : false,
        ], 
    ];

}