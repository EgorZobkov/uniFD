public function usersStoriesData($user_id=0){
    global $app;

    $result = [];
    $stories = [];

    if($user_id){
        $getUsersStories = $app->model->stories->getAll("user_id=?", [$user_id]);
    }else{
        $getUsersStories = $app->model->stories->sort("time_create desc limit 50")->getAll();
    }

    if($getUsersStories){
        foreach ($getUsersStories as $key => $value) {

            $stories = [];

            $user = $app->model->users->findById($value['user_id']);

            $shop = $app->component->shop->getActiveShopByUserId($value['user_id']);

            $getUserStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("status=? and user_id=?", [1, $value["user_id"]]);

            if($getUserStoriesMedia){

                foreach ($getUserStoriesMedia as $story_key => $story_value) {

                    $ad = [];
                    $media = _json_decode($story_value["media"]);

                    if($story_value["item_id"]){
                        $ad = $app->component->ads->getAd($story_value["item_id"]);
                    }

                    $count = $app->model->stories_media_views->count("story_id=?", [$story_value["id"]]);

                    $stories[] = [
                        "id"=>$story_value["id"], 
                        "image"=>$media["type"] == "image" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : $app->storage->path("user-attached")->name($media["folder"]."/".$media["preview"])->host(true)->get(),
                        "link"=>$media["type"] == "video" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : null,
                        "timestamp"=>strtotime($story_value["time_create"]), 
                        "status"=>$story_value["status"], 
                        "count_view"=>$count . ' ' . endingWord($count, translate("tr_f43eede2d635af40f32a2b21c42daa45"), translate("tr_bd99f22dcfb3422bf42ca4767607d427"), translate("tr_9636280c1189c0e4d5ac17cc03cc6af3")), 
                        "type"=>$media["type"], 
                        "duration"=>$story_value["duration"] ?: 30, 
                        "ad"=> $ad ? ["id"=>$story_value["item_id"], "title"=>$ad->title, "image"=>$ad->media->images->first, "price"=>$this->price(["ad"=>(array)$ad])] : null
                    ];

                }

                $result[] = [
                    "id"=>$value["user_id"],
                    "name"=>$app->user->name($user),
                    "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
                    "timestamp"=>strtotime($value["time_create"]),
                    "items"=>$stories ?: null,
                    "shop" => $shop ? [
                        "id"=>$shop->id,
                        "title"=>$shop->title,
                        "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                        "text"=>$shop->text,
                    ] : null                        
                ];

            }

        }
    }

    return $result;

}