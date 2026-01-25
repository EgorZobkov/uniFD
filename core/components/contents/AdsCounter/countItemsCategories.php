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