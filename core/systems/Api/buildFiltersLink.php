public function buildFiltersLink($filters=[], $category_id=0, $city_id=0, $region_id=0, $country_id=0){
    global $app;

    $link = "";
    $result = [];

    if(!$app->component->geo->statusMultiCountries()){

        if($city_id){
            $geo = $app->model->geo_cities->find("id=? and status=?", [$city_id, 1]);
            if($geo->region_id){
                $region = $app->model->geo_regions->find("id=? and status=?", [$geo->region_id, 1]);
                $result[] = $region->alias;
            }
            $result[] = $geo->alias;
        }elseif($region_id){
            $geo = $app->model->geo_regions->find("id=? and status=?", [$region_id, 1]);
            $result[] = $geo->alias;
        }elseif($country_id){
            $result[] = "all";
        }

    }else{

        if($city_id){
            $geo = $app->model->geo_cities->find("id=? and status=?", [$city_id, 1]);
            if($geo){
                $country = $app->model->geo_countries->find("id=?", [$geo->country_id]);
                $result[] = $country->alias;
                if($geo->region_id){
                    $region = $app->model->geo_regions->find("id=? and status=?", [$geo->region_id, 1]);
                    $result[] = $region->alias;
                }
                $result[] = $geo->alias;
            }
        }elseif($region_id){
            $geo = $app->model->geo_regions->find("id=? and status=?", [$region_id, 1]);
            if($geo){
                $country = $app->model->geo_countries->find("id=?", [$geo->country_id]);
                $result[] = $country->alias;
                $result[] = $geo->alias;
            }
        }elseif($country_id){
            $geo = $app->model->geo_countries->find("id=? and status=?", [$country_id, 1]);
            $result[] = $geo->alias;
        }

    }

    if($category_id){
        $chain = $app->component->ads_categories->chainCategory($category_id);
        $result[] = $chain->chain_build_alias_request;
    }

    if($result){
        if($filters){
            $link = implode("/", $result) . '?' . http_build_query($filters);
        }else{
            $link = implode("/", $result);   
        }
    }else{
        if($filters){
            $link = 'all?' . http_build_query($filters);  
        }          
    }

    return $link;

}