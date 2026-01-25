public function storiesPublication($params=[], $user_id=0){
    global $app;

    $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

    if(!$tariff->items->add_stories){
        return json_answer(["status"=>false]);
    }

    $media = $app->component->stories->uploadMedia($params['name'], $params['type']);

    if(!$media){
        return ["status"=>false, "answer"=>translate("tr_8b1269c207872d7f783a4fe90ecf0ecb")];
    }

    if($app->settings->stories_moderation_status){
        $status = 0;
    }else{
        $status = 1;
    }

    if($params['type'] == "image"){
        $duration = $app->settings->stories_max_duration_image;
    }else{
        if($params["video_duration"]){
            $duration = $params["video_duration"] <= $app->settings->stories_max_duration_video ? $params["video_duration"] : $app->settings->stories_max_duration_video;
        }else{
            $duration = $app->settings->stories_max_duration_video;
        }
    }

    if($tariff->items->stories_3_days){
        $time_expiration = $app->datetime->addDay(3)->getDate();
    }elseif($tariff->items->stories_7_days){
        $time_expiration = $app->datetime->addDay(7)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $getStory = $app->model->stories->find("user_id=?", [$user_id]);

    if($getStory){

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

       $app->model->stories->update(["time_create"=>$app->datetime->getDate()], ["user_id=?", [$user_id]]);

    }else{

       $app->model->stories->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate()]);

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

    }

    $app->event->addStories(["user_id"=>$user_id]);

    if($app->settings->stories_moderation_status){
        return ["status"=>true, "answer"=>translate("tr_bd3b3e8aec6a731f69092d1dc03fd0ea")];
    }else{
        return ["status"=>true, "answer"=>translate("tr_86c67ada3b0abc338f70d5e887c81c0d")];
    }

}