public function deactivation($service_id=0, $ad_id=0){
    global $app;

    $getService = $app->model->ads_services->find("id=?", [$service_id]);

    if($getService->alias == "urgently"){

        $app->model->ads_data->update(["service_urgently_status"=>0], $ad_id);

    }elseif($getService->alias == "highlight"){

        $app->model->ads_data->update(["service_highlight_status"=>0], $ad_id);

    }elseif($getService->alias == "top"){

        $ad = $app->model->ads_data->find("id=?", [$ad_id]);

        $app->model->ads_data->update(["service_top_status"=>1, "time_sorting"=>$ad->time_create], $ad_id);

    }elseif($getService->alias == "package"){

        $ad = $app->model->ads_data->find("id=?", [$ad_id]);

        $app->model->ads_data->update(["service_urgently_status"=>0, "service_highlight_status"=>0, "service_top_status"=>0, "time_sorting"=>$ad->time_create], $ad_id);

    }
  
}