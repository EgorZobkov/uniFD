public function deleteAllByUserId($user_id=0){
    global $app;

    $ads = $app->model->ads_data->getAll("user_id=?", [$user_id]);

    if($ads){

        foreach ($ads as $key => $value) {

            $app->model->ads_delete->insert(["user_id"=>$value["user_id"], "ad_id"=>$value["id"], "time_create"=>$app->datetime->getDate(), "data"=>_json_encode($value)]);

            $this->deleteMedia(_json_decode($value["media"]));

            $app->model->ads_data->delete("id=?", [$value["id"]]);
            $app->model->ads_filters_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_city_districts_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_city_metro_ids->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_services_orders->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_views->delete("ad_id=?", [$value["id"]]);
            $app->model->ads_booking_data->delete("ad_id=?", [$value["id"]]);
            $app->component->ads_counter->updateCount($value["category_id"],$value["city_id"],$value["region_id"],$value["country_id"]);

        }
   
    }

}