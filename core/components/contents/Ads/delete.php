public function delete($id=0, $user_id=0){
    global $app;

    if($user_id){
        $getData = $app->model->ads_data->getRow("id=? and user_id=?", [$id, $user_id]);
    }else{
        $getData = $app->model->ads_data->getRow("id=?", [$id]);
    }

    if($getData){

        $app->model->ads_delete->insert(["user_id"=>$getData["user_id"], "ad_id"=>$id, "time_create"=>$app->datetime->getDate(), "data"=>_json_encode($getData)]);

        $this->deleteMedia(_json_decode($getData["media"]));

        $app->model->ads_data->delete("id=?", [$id]);
        $app->model->ads_filters_ids->delete("ad_id=?", [$id]);
        $app->model->ads_city_districts_ids->delete("ad_id=?", [$id]);
        $app->model->ads_city_metro_ids->delete("ad_id=?", [$id]);
        $app->model->ads_services_orders->delete("ad_id=?", [$id]);
        $app->model->ads_views->delete("ad_id=?", [$id]);
        $app->model->ads_booking_data->delete("ad_id=?", [$id]);
        $app->component->ads_counter->updateCount($getData["category_id"],$getData["city_id"],$getData["region_id"],$getData["country_id"]);
        
    }

}