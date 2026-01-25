public function delete($story_id=0, $user_id=0){
    global $app;

    if($user_id){
        $getStory = $app->model->stories_media->find("id=? and user_id=?", [$story_id,$user_id]);
    }else{
        $getStory = $app->model->stories_media->find("id=?", [$story_id]);
    }

    if($getStory){

        $app->model->stories_media->delete("id=?", [$story_id]);

        $media = _json_decode($getStory->media);
        $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->delete();
        $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->delete();

        if(!$app->model->stories_media->count("user_id=?", [$user_id])){
            $app->model->stories->delete("user_id=?", [$user_id]);
        }

        $app->model->stories_media_views->delete("story_id=?", [$story_id]);
        
    }

}