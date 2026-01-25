<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class AdsCounter
{

 public $alias = "ads_counter";

 public function countItemsCategories($category_id=0, $city_id=0, $region_id=0, $country_id=0){
    global $app;

    $query = [];
    $params = [];

    if($category_id){
        $query[] = "category_id=?";
        $params[] = $category_id;
    }

    if($city_id){
        $query[] = "city_id=?";
        $params[] = $city_id;
    }

    if($region_id){
        $query[] = "region_id=?";
        $params[] = $region_id;
    }

    if($country_id){
        $query[] = "country_id=?";
        $params[] = $country_id;
    }

    $count_items = $app->db->getSumByTotal("count_items", "uni_ads_stat", implode(" and ", $query), $params);

    return $count_items ?: '';
}

public function getCountActiveAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=?", [1]),0,'.', ' ');
}

public function getCountAllAds(){
    global $app;
    return numberFormat($app->model->ads_data->count(),0,'.', ' ');
}

public function getCountByStatus($status=null){
    global $app;

    if(isset($status)){
        return numberFormat($app->model->ads_data->count("status=?", [$status]),0,'.', ' ');
    }

    return 0;
}

public function getCountModerationAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=?", [0]),0,'.', ' ');
}

public function getCountTodayAds(){
    global $app;
    return numberFormat($app->model->ads_data->count("status=? and date(time_create)=?", [1, $app->datetime->format("Y-m-d")->getDate()]),0,'.', ' ');
}

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



}