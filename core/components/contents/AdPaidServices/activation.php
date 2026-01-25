 public function activation($alias=null, $ad_id=0, $count_day=0){
    global $app;

    if($alias == "urgently"){

        $app->model->ads_data->update(["service_urgently_status"=>1], $ad_id);

    }elseif($alias == "highlight"){

        $app->model->ads_data->update(["service_highlight_status"=>1], $ad_id);

    }elseif($alias == "stories"){

        $app->component->stories->addWaitingMakeCollage($ad_id, $count_day, $app->user->data->id);

    }elseif($alias == "top"){

        $app->model->ads_data->update(["service_top_status"=>1, "time_sorting"=>$app->datetime->getDate()], $ad_id);

    }elseif($alias == "package"){

        $app->model->ads_data->update(["service_urgently_status"=>1, "service_highlight_status"=>1, "service_top_status"=>1, "time_sorting"=>$app->datetime->getDate()], $ad_id);
        $app->component->stories->addWaitingMakeCollage($ad_id, $count_day, $app->user->data->id);

    }
  
}