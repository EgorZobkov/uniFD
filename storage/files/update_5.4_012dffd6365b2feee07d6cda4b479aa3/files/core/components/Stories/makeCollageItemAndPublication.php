public function makeCollageItemAndPublication($item_id=0, $count_day=0){
    global $app;

    $images = [];
    $media = [];

    $ad = $app->component->ads->getAd($item_id);

    if(!$ad || $ad->delete){
        return;
    }

    if($ad->media->images->all){

        foreach (array_slice($ad->media->inline, 0, 4) as $key => $value) {

            if($value->type == "image"){
                if(@getimagesize($value->link)){
                    $images[] = $value->link;
                }
            }elseif($value->type == "video"){
                $images[] = $value->preview;
            }

        }

        if($images){
            $folder = md5(time().'-'.uniqid());
            $generatedName = md5(time().'-'.uniqid());
            createFolder($app->config->storage->users->attached.'/'.$folder);
            $collage = new MakeCollage();
            $result = $collage->make(600, 600)->padding(5)->background('#000')->from($images);
            $result->save($app->config->storage->users->attached.'/'.$folder."/".$generatedName.".webp");
            $media = ["name"=>$generatedName.'.webp', "folder"=>$folder, "type"=>"image"];
        }else{
            return;
        }

    }else{
        return;
    }

    if($count_day){
        $time_expiration = $app->datetime->addDay($count_day)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $getStory = $app->model->stories->find("user_id=?", [$ad->user_id]);

    if($getStory){

       $app->model->stories_media->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media ? _json_encode($media) : null, "status"=>1, "time_expiration"=>$time_expiration, "city_id"=>$ad->city_id, "category_id"=>$ad->category_id, "item_id"=>$item_id]);

       $app->model->stories->update(["time_create"=>$app->datetime->getDate()], ["user_id=?", [$ad->user_id]]);

    }else{

       $app->model->stories->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate()]);

       $app->model->stories_media->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media ? _json_encode($media) : null, "status"=>1, "time_expiration"=>$time_expiration, "city_id"=>$ad->city_id, "category_id"=>$ad->category_id, "item_id"=>$item_id]);

    }

}