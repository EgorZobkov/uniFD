public function deleteAllByUserId($user_id=0){
    global $app;

    $getStories = $app->model->stories_media->getAll("user_id=?", [$user_id]);

    if($getStories){

        foreach ($getStories as $key => $value) {
            
            $media = _json_decode($value["media"]);
            $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->delete();
            $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->delete();

        }
        
    }

    $app->model->stories->delete("user_id=?", [$user_id]);
    $app->model->stories_media->delete("user_id=?", [$user_id]);
    $app->model->stories_media_views->delete("user_id=?", [$user_id]);

}