public function updateCount($category_id=0, $city_id=0, $region_id=0, $country_id=0, $status=0){
    global $app;

    $count = $app->model->ads_data->count("category_id=? and city_id=? and region_id=? and country_id=? and status=?", [$category_id,intval($city_id),intval($region_id),intval($country_id),1]);

    if($count){

        $mainIds = $app->component->ads_categories->getReverseMainIds($category_id);

        if($mainIds){

            foreach (explode(",", $mainIds) as $key => $value) {

                $stat = $app->model->ads_stat->find("category_id=? and city_id=? and region_id=? and country_id=?", [$value,intval($city_id),intval($region_id),intval($country_id)]);
                
                if($stat){
                    $app->model->ads_stat->update(["count_items"=>$count], $stat->id);
                }else{
                    $app->model->ads_stat->insert(["count_items"=>$count, "category_id"=>$value, "city_id"=>intval($city_id), "region_id"=>intval($region_id), "country_id"=>intval($country_id)]);
                }                

            }

        }else{

            $stat = $app->model->ads_stat->find("category_id=? and city_id=? and region_id=? and country_id=?", [$category_id,intval($city_id),intval($region_id),intval($country_id)]);
            
            if($stat){
                $app->model->ads_stat->update(["count_items"=>$count], $stat->id);
            }else{
                $app->model->ads_stat->insert(["count_items"=>$count, "category_id"=>$category_id, "city_id"=>intval($city_id), "region_id"=>intval($region_id), "country_id"=>intval($country_id)]);
            }            

        }

    }else{

        $mainIds = $app->component->ads_categories->getReverseMainIds($category_id);
        $app->model->ads_stat->delete("category_id IN(".$mainIds.") and city_id=? and region_id=? and country_id=?", [intval($city_id),intval($region_id),intval($country_id)]);

    }

}