public function addGeoDistricts($ids=[], $ad_id=0){
    global $app;

    if($ad_id){
        $app->model->ads_city_districts_ids->delete("ad_id=?", [$ad_id]);

        if($ids){
            if(is_array($ids)){
                foreach (array_slice($ids, 0,10) as $id) {
                    if($id){
                        $app->model->ads_city_districts_ids->insert(["ad_id"=>$ad_id, "district_id"=>$id]);
                    }
                }
            }
        }
    }

}