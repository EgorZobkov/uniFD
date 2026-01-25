public function changeStatus($story_id=0){
    global $app;

    $getStory = $app->model->stories_media->find("id=?", [$story_id]);

    $tariff = $app->component->service_tariffs->getOrderByUserId($getStory->user_id);

    if($tariff->items->stories_3_days){
        $time_expiration = $app->datetime->addDay(3)->getDate();
    }elseif($tariff->items->stories_7_days){
        $time_expiration = $app->datetime->addDay(7)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $app->model->stories_media->update(["status"=>1, "time_expiration"=>$time_expiration],$story_id);

}