public function saveCatalogSearch($params=[], $user_id=0){
    global $app;

    $result = [];

    $filters = $params["filters"] ? _json_decode(html_entity_decode($params["filters"])) : [];

    if($filters["filters"]){
        $result["filter"] = $this->normalizedFiltersAllItemsArray($filters["filters"]);
    }

    if($params["search"]){
        $result["search"] = $params["search"];
    }

    $urgently = $filters["urgently"] ? true : false;
    $delivery_status = $filters["delivery_status"] ? true : false;
    $condition_new_status = $filters["condition_new_status"] ? true : false;
    $condition_brand_status = $filters["condition_brand_status"] ? true : false;

    if($filters["price_from"]){
        $result["filter"]["price_from"] = $filters["price_from"];
    }

    if($filters["price_to"]){
        $result["filter"]["price_to"] = $filters["price_to"];
    }

    if($urgently){
        $result["filter"]["switch"]["urgently"] = true;
    }

    if($delivery_status){
        $result["filter"]["switch"]["delivery"] = true;
    }

    if($condition_new_status){
        $result["filter"]["switch"]["only_new"] = true;
    }

    if($condition_brand_status){
        $result["filter"]["switch"]["only_brand"] = true;
    }

    if($filters["calendar_date_start"]){
        $result["filter"]["calendar_date_start"] = $filters["calendar_date_start"];
    }

    if($filters["calendar_date_end"]){
        $result["filter"]["calendar_date_end"] = $filters["calendar_date_end"];
    }

    $link = trim($this->buildFiltersLink($result, $params["cat_id"], $params["city_id"], $params["region_id"], $params["country_id"]), "/");

    $token = md5($link ?: null);

    $get = $app->model->users_searches->find("user_id=? and token=?", [$user_id, $token]);

    if($get){
        $app->model->users_searches->delete("id=?", [$get->id]);
        return ["answer"=>translate("tr_7f28e84837e808158a5d73734f7e7d7a"), "label"=>translate("tr_852be42059679d4e4fef58aad5f3fa2f")];
    }else{
        $app->model->users_searches->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "params"=>$result ? _json_encode($result) : null, "category_id"=>$params["cat_id"]?:0, "city_id"=>$params["city_id"]?:0, "region_id"=>$params["region_id"]?:0, "country_id"=>$params["country_id"]?:0,"token"=>$token, "link"=>$link ?: null]);
        return ["answer"=>translate("tr_35e32673f23298102ec36862d57f0154"), "label"=>translate("tr_f6acf24dca325b44869ec3fe34ef5083")];
    }

}