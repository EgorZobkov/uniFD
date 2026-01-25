public function update($params=[], $user_id=0, $ad_id=0, $admin=false){
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$ad_id,$user_id]);

    if(!$ad) return [];

    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    if(!$admin){
        $detect_status = $this->detectStatus($params,$user_id,$ad);
    }else{
        $detect_status = (object)["status" => !$ad->status ? 0 : 1, "reason_code" => null];
    }

    $expiration = $this->calculationTimeExpiration($params["term_date_day"]);

    $media = $this->uploadMedia($params['media'], $ad);

    $geo = $app->component->geo->getCityData($params['geo_city_id']);

    if(empty($params['geo_address'])){
        $params['geo_address_latitude'] = 0;
        $params['geo_address_longitude'] = 0;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["price_fixed_change"]){
        $price_fixed_status = (int)$params['price_fixed_status'];
    }else{
        $price_fixed_status = 1;
    }

    if(intval($params["not_limited"])){
        $in_stock = 0;
    }else{
        $in_stock = (int)$params["in_stock"] ?: 1;
    }

    if($app->component->ads_categories->categories[$params['category_id']]["filter_generation_title"]){
        $params['title'] = $app->component->ads_filters->generationTitle($params['filter'], $params['category_id']);
    }

    if(!$app->user->data->service_tariff->items->autorenewal){
        $params["auto_renewal_status"] = 0;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update([
        "title"=>$params['title'], 
        "alias"=>slug($params['title']),
        "price"=>$params["price"],
        "old_price"=>$params["old_price"],
        "text"=>trimStr($params['text'],$app->settings->board_publication_max_length_text, false),
        "address"=>$app->component->geo->searchAddressByCoordinates($params['geo_address_latitude'],$params['geo_address_longitude']),
        "address_latitude"=>$params['geo_address_latitude'] ?: null,
        "address_longitude"=>$params['geo_address_longitude'] ?: null,
        "publication_period"=>$expiration->days,
        "currency_code"=>$this->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$this->getPriceMeasure($params["price_measurement"]),
        "media"=>$media,
        "contacts"=>$this->buildContacts($params),
        "contact_method"=>$params['contact_method'],
        "category_id"=>$params['category_id'],
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$this->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "price_fixed_status"=>$price_fixed_status,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_update"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal_status"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "delivery_status"=>(int)$params["delivery_status"],
        "partner_button_name"=>trimStr($params["partner_button_name"],60, false) ?: null,
        "partner_button_color"=>$params["partner_button_color"] ?: null,
    ], $ad_id);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filter'], $params['category_id'], $ad_id);

    $this->addFreePublications($ad_id,$user_id,$params['category_id']);
    $this->addGeoDistricts($params["geo_district_id"],$ad_id);
    $this->addGeoMetro($params["geo_metro_id"],$ad_id);
    $this->addBookingData($params,$ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

    return (object)["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$params['category_id'], "detect_status"=>$detect_status, "data"=>$app->component->ads->getAd($ad_id)];

}