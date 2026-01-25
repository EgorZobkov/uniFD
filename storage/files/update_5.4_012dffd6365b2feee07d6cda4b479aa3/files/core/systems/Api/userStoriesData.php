public function userStoriesData($user_id=0){
    global $app;

    $result = [];

    $user = $app->model->users->findById($user_id);

    if(!$user){
        return [];
    }

    $shop = $app->component->shop->getActiveShopByUserId($user_id);

    $getUserStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("user_id=? and status=?", [$user_id, 1]);

    if($getUserStoriesMedia){
        foreach ($getUserStoriesMedia as $key => $value) {

            $ad = [];
            $media = _json_decode($value["media"]);

            if($value["item_id"]){
                $ad = $app->component->ads->getAd($value["item_id"]);
            }

            $count = $app->model->stories_media_views->count("story_id=?", [$value["id"]]);

            $result[] = [
                "id"=>$value["id"], 
                "image"=>$media["type"] == "image" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : $app->storage->path("user-attached")->name($media["folder"]."/".$media["preview"])->host(true)->get(),
                "link"=>$media["type"] == "video" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : null,
                "timestamp"=>strtotime($value["time_create"]), 
                "status"=>$value["status"], 
                "count_view"=>$count . ' ' . endingWord($count, translate("tr_f43eede2d635af40f32a2b21c42daa45"), translate("tr_bd99f22dcfb3422bf42ca4767607d427"), translate("tr_9636280c1189c0e4d5ac17cc03cc6af3")), 
                "type"=>$media["type"], 
                "duration"=>$value["duration"] ?: 30,
                "ad"=> $ad ? ["id"=>$value["item_id"], "title"=>$ad->title, "image"=>$ad->media->images->first, "price"=>$this->price(["ad"=>(array)$ad])] : null, 
                "user"=>[
                    "id"=>$user->id,
                    "name"=>$app->user->name($user),
                    "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
                ],
                "shop" => $shop ? [
                    "id"=>$shop->id,
                    "title"=>$shop->title,
                    "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                    "text"=>$shop->text,
                ] : null
            ];

        }
    }

    return $result;

}