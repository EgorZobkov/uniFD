public function publicationByImport($params=[]){
    global $app;

    $detect_status = (object)["status" => 1, "reason_code" => null];
    
    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    $expiration = $this->calculationTimeExpiration($params["term_date_day"]);

    $geo = $app->component->geo->getCityData($params['geo_city_id']);

    if(intval($params["not_limited"])){
        $in_stock = 0;
    }else{
        $in_stock = (int)$params["in_stock"] ?: 1;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $params["article_number"] = generateNumberCode(10);

    $ad_id = $app->model->ads_data->insert([
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
        "media"=>$params['media'] ?: null,
        "contacts"=>$this->buildContacts($params),
        "contact_method"=>"all",
        "category_id"=>$params['category_id'],
        "user_id"=>(int)$params['user_id'],
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$this->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "article_number"=>$params["article_number"],
        "price_fixed_status"=>1,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_create"=>$app->datetime->getDate($params["date"]),
        "time_sorting"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>(int)$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "import_id"=>$params["import_id"],
        "import_item_id"=>$params["import_item_id"] ?: null,
    ]);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filter'], $params['category_id'], $ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

}