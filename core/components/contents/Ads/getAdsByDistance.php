public function getAdsByDistance($params=[],$category_id=0,$not_ids=[]){
    global $app;

    $ids = [];
    $content = "";

    if(!$app->settings->board_ads_geo_distance) return;

    $geo = $app->session->get("geo");

    $build = $app->component->catalog->buildQuery($params, $category_id);

    if($geo){

        $coor = $app->geo->coordinatesByRadius($geo->latitude, $geo->longitude, $app->settings->board_ads_geo_distance);

        if($build && $geo->latitude && $geo->longitude){

            if($not_ids){
                $build["query"] = $build["query"] . " and id NOT IN(".implode(",", $not_ids).")";
            }

            $build["query"] = $build["query"] . " and ((`geo_latitude` BETWEEN ? AND ?) AND (`geo_longitude` BETWEEN ? AND ?))";

            $build["params"][] = $coor["min_lat"];
            $build["params"][] = $coor["max_lat"];
            $build["params"][] = $coor["min_lon"];
            $build["params"][] = $coor["max_lon"];

            $data = $app->model->ads_data->sort("id desc limit ".$app->settings->out_default_count_city_distance_items?:28)->getAll($build["query"], $build["params"]);

            if($data){
                foreach ($data as $key => $value) {

                    $value = $this->getDataByValue($value);

                    $ids[] = $value->id;

                    $content .= $app->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid.tpl');

                }
                $app->component->catalog->updateCountDisplay($ids);    
            }    

        }

    }

    return $content;

}