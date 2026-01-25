<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class Api
 {

 public $data = [];
 public $user = [];
 
 public function adAvailableStatus($unlimitedly=false, $available=0){
    if($unlimitedly){
       return true;
    }else{
       if($available > 0){
         return true;
       }else{
         return false;
       }
    }
 }

public function adCreate($params=[], $user_id=0){
    global $app;

    if(!$app->component->ads_categories->categories[$params['category_id']]) return [];

    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    $detect_status = $app->component->ads->detectStatus($params,$user_id);
    $service_tariff = $app->component->service_tariffs->getOrderByUserId($user_id);
    $expiration = $app->component->ads->calculationTimeExpiration($params["term_date_day"]);
    $media = $app->component->ads->uploadMedia($params['media']);

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
        $params['title'] = $app->component->ads_filters->generationTitle($params['filters'], $params['category_id']);
    }

    if(!$service_tariff->items->autorenewal){
        $params["auto_renewal_status"] = 0;
    }

    if($params["old_price"]){
        if($params["price"] >= $params["old_price"]){
            $params["old_price"] = 0;
        }
    }

    $params["article_number"] = generateNumberCode(10);

    if(!$params["price_measurement"]){

        if($app->component->ads_categories->categories[$params['category_id']]["price_measure_ids"]){
            $params["price_measurement"] = _json_decode($app->component->ads_categories->categories[$params['category_id']]["price_measure_ids"])[0];
        }

    }

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
        "currency_code"=>$app->component->ads->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$app->component->ads->getPriceMeasure($params["price_measurement"]),
        "media"=>$media,
        "contacts"=>$app->component->ads->buildContacts($params),
        "contact_method"=>$params['contact_method'] ?: "all",
        "category_id"=>$params['category_id'],
        "user_id"=>$user_id,
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$app->component->ads->buildSearchTags($params,$geo),
        "time_expiration"=>$expiration->date,
        "article_number"=>$params["article_number"],
        "price_fixed_status"=>$price_fixed_status,
        "price_gratis_status"=>(int)$params["price_gratis_status"],
        "time_create"=>$app->datetime->getDate(),
        "time_sorting"=>$app->datetime->getDate(),
        "online_view_status"=>(int)$params["online_view_status"],
        "condition_new_status"=>(int)$params["condition_new_status"],
        "condition_brand_status"=>(int)$params["condition_brand_status"],
        "auto_renewal_status"=>(int)$params["auto_renewal_status"],
        "not_limited"=>(int)$params["not_limited"],
        "in_stock"=>$in_stock,
        "link_video"=>$params["link_video"],
        "external_content"=>$params["external_content"] ? encrypt($params["external_content"]) : null,
        "partner_link"=>$params["partner_link"] ?: null,
        "booking_status"=>(int)$app->component->ads_categories->categories[$params['category_id']]["booking_status"],
        "delivery_status"=>(int)$params["delivery_status"],
        "partner_button_name"=>trimStr($params["partner_button_name"],60, false) ?: null,
        "partner_button_color"=>$params["partner_button_color"] ?: null,
    ]);

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filters'], $params['category_id'], $ad_id);

    $app->component->ads->addFreePublications($ad_id,$user_id,$params['category_id']);
    $app->component->ads->addBookingData($params,$ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

    $chain = $app->component->ads_categories->chainCategory($params['category_id']);

    $app->event->createAd(["user_id"=>$user_id, "ad_id"=>$ad_id, "ad_title"=>$params['title'], "ad_category_name"=>$chain->chain_build]);

    return (object)["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$params['category_id'], "detect_status"=>$detect_status];

}

public function adData($value=[]){
    global $app;

    $markers = [];
    $rating_array = [];
    $status_name = "";
    $lat = "";
    $lon = "";

    if($value->delivery_status){
        $markers[] = ['name'=>translate("tr_b973ee86903271172c9b4f5529bc19bb"), 'color'=>'#f81155'];
    }

    if($value->booking_status){
        if($app->component->ads_categories->categories[$value->category_id]["booking_action"] == "booking"){
            $markers[] = ['name'=>translate("tr_18683b0d308a45672c6569209d040ebe"), 'color'=>'#f81155'];
        }else{
            $markers[] = ['name'=>translate("tr_83e1d0278ef91f7851b947dc73e66491"), 'color'=>'#f81155'];
        }  
    }

    if($value->condition_new_status){
        $markers[] = ['name'=>translate("tr_963d95509d21446ecc58963ffbc37251"), 'color'=>'#f81155'];
    }

    if($value->service_urgently_status){
        $markers[] = ['name'=>translate("tr_c85cf9e96515efc35d01f5ead5495666"), 'color'=>'#f81155'];
    }

    if(round($value->total_rating, 1) >= 4.0){
        $rating_array = ["color"=>"#00c257", "rating"=>sprintf("%.1f", $value->total_rating), "reviews_label"=>$value->total_reviews.' '.endingWord($value->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"))];
    }elseif(round($value->total_rating, 1) >= 3.0 && round($value->total_rating, 1) < 4.0){
        $rating_array = ["color"=>"#f79900", "rating"=>sprintf("%.1f", $value->total_rating), "reviews_label"=>$value->total_reviews.' '.endingWord($value->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"))];
    }else{
        $rating_array = ["color"=>"#808080", "rating"=>sprintf("%.1f", $value->total_rating), "reviews_label"=>$value->total_reviews.' '.endingWord($value->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"))];
    }

    if($value->address_latitude || $value->geo_latitude){
        $lat = $value->address_latitude ? $value->address_latitude : $value->geo_latitude;
    }

    if($value->address_longitude || $value->geo_longitude){
        $lon = $value->address_longitude ? $value->address_longitude : $value->geo_longitude;
    }

    $shop = $app->component->shop->getActiveShopByUserId($value->user->id);

    return [
        "id"=>$value->id,
        "title"=>html_entity_decode($value->title),
        "text"=>html_entity_decode($value->text),
        "price"=>$this->price(["ad"=>$value]),
        "city"=>$value->geo ? $value->geo->name : null,
        "city_area"=>$value->geo ? $value->geo->name : null,
        "time_create"=>$app->datetime->outLastTime($value->time_create),
        "rating" => sprintf("%.1f", $value->total_rating),
        "reviews" => $value->total_reviews,
        "rating_array"=>$rating_array,
        "count_view"=>$app->component->ads->getViews($value->id),
        "images"=>$value->media->count ? $value->media->images->all : [$app->storage->host(true)->noImage()],
        "user"=>[
            "id" => $value->user->id,
            "display_name" => $shop ? $shop->title : $app->user->name($value->user, true),
            "name" => $value->user->name,
            "surname" => $value->user->surname,
            "organization_name" => $value->user->organization_name ?: null,
            "user_status" => $value->user->user_status == 1 ? "user" : "company",
            "avatar" => $shop ? $app->storage->name($shop->image)->host(true)->get() : $app->storage->name($value->user->avatar)->host(true)->get(),
            "verification_status" => $value->user->verification_status ? true : false,
            "shop" => $shop ? [
                "id"=>$shop->id,
                "title"=>$shop->title,
                "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                "text"=>$shop->text,
            ] : null
        ],
        "markers"=>$markers,
        "link"=>$app->component->ads->buildAliasesAdCard($value),
        "status"=>$value->status,
        "status_name"=>$this->statusNameAd($value->status),
        "in_favorites"=>false,
        "lat"=>$lat ?: null,
        "lon"=>$lon ?: null,
        "count_images"=>$value->media->count,
        "geo_status"=>(int)$value->category->change_city_status,
        "auction" => [
            "status" => false,
            "duration" => date('Y-m-d H:i:s'),
            "seconds_completed" => date('Y-m-d H:i:s'),
            "completed" => false, 
        ],
        "condition_status"=>$value->condition_new_status ? true : false, 
        "highlight_status"=>$value->service_highlight_status ? true : false,
        "type_goods"=>$value->category->type_goods ?: null,
    ];
}

public function adUpdate($params=[], $user_id=0, $ad_id=0){
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$ad_id,$user_id]);

    if(!$ad || !$app->component->ads_categories->categories[$params['category_id']]) return [];

    $params['price'] = formattedPrice($params['price']);
    $params['old_price'] = formattedPrice($params['old_price']);

    $service_tariff = $app->component->service_tariffs->getOrderByUserId($user_id);
    $detect_status = $app->component->ads->detectStatus($params,$user_id,$ad);
    $expiration = $app->component->ads->calculationTimeExpiration($params["term_date_day"]);
    $media = $app->component->ads->uploadMedia($params['media'], $ad);
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
        $params['title'] = $app->component->ads_filters->generationTitle($params['filters'], $params['category_id']);
    }

    if(!$service_tariff->items->autorenewal){
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
        "currency_code"=>$app->component->ads->getCurrencyCode($params["price_currency_code"]),
        "price_measure_id"=>$app->component->ads->getPriceMeasure($params["price_measurement"]),
        "media"=>$media,
        "contacts"=>$app->component->ads->buildContacts($params),
        "contact_method"=>$params['contact_method'],
        "category_id"=>$params['category_id'],
        "city_id"=>(int)$geo->id,
        "region_id"=>(int)$geo->region->id,
        "country_id"=>(int)$geo->country->id,
        "status"=>$detect_status->status,
        "reason_blocking_code"=>$detect_status->reason_code,
        "geo_latitude"=>$geo->latitude ?: null,
        "geo_longitude"=>$geo->longitude ?: null,
        "search_tags"=>$app->component->ads->buildSearchTags($params,$geo),
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

    $app->component->ads_filters->addSelectedFilterItemsAd($params['filters'], $params['category_id'], $ad_id);

    $app->component->ads->addFreePublications($ad_id,$user_id,$params['category_id']);
    $app->component->ads->addBookingData($params,$ad_id);

    $app->component->ads_counter->updateCount($params['category_id'], (int)$geo->id, (int)$geo->region->id, (int)$geo->country->id, $detect_status->status);

    return (object)["ad_id"=>$ad_id];

}

public function buildArrayGeoDefaultCountry(){
    global $app;

    return $app->component->geo->defaultCountry ? ["id"=>$app->component->geo->defaultCountry->id, "name"=>translateFieldReplace($app->component->geo->defaultCountry, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($app->component->geo->defaultCountry, "declension", $_REQUEST["lang_iso"]), "lat"=>$app->component->geo->defaultCountry->capital_latitude ?: null, "lon"=>$app->component->geo->defaultCountry->capital_longitude ?: null] : null;

}

public function buildFiltersApp($params=[]){
    global $app;

    $result = [];
    $filters = [];

    if($params){

        if($params["search"]){
            $result["search"] = $params["search"];
        }

        if($params["price_from"]){
            $result["price_from"] = $params["price_from"];
        }

        if($params["price_to"]){
            $result["price_to"] = $params["price_to"];
        }

        if($params["calendar_date_start"]){
            $result["calendar_date_start"] = date("d.m.Y", strtotime($params["calendar_date_start"]));
        }

        if($params["calendar_date_end"]){
            $result["calendar_date_end"] = date("d.m.Y", strtotime($params["calendar_date_end"]));
        }

        if($params["switch"]["urgently"]){
            $result["urgently"] = true;
        }

        if($params["switch"]["delivery"]){
            $result["delivery_status"] = true;
        }

        if($params["switch"]["only_new"]){
            $result["condition_new_status"] = true;
        }

        if($params["switch"]["only_brand"]){
            $result["condition_brand_status"] = true;
        }

        foreach ($params as $filter_id => $nested) {
            if(intval($filter_id)){

                $filter = $app->model->ads_filters->find("id=? and status=?", [(int)$filter_id, 1]);

                if($filter){
                    if($filter->view == "input"){
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>(int)$params[$filter_id]["from"] ? substr($params[$filter_id]["from"], 0, 20) : '', "field"=>"start"];
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>(int)$params[$filter_id]["to"] ? substr($params[$filter_id]["to"], 0, 20) : '', "field"=>"end"];
                    }elseif($filter->view == "input_text"){
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>$params[$filter_id][0] ? substr($params[$filter_id][0], 0, 50) : '', "field"=>"text"];
                    }else{

                        foreach ($nested as $item_id) {
                            $item = $app->model->ads_filters_items->find("filter_id=? and id=?", [(int)$filter_id, (int)$item_id]);
                            if($item){
                                $filters[] = ["filterId"=>(string)$filter_id, "item"=>(string)$item_id, "name"=>(string)$item->name];
                            }
                        }

                    }
                }

            }
        }

        if($filters){
            $result["filters"] = $filters;
        }

    }

    return $result;

}

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

function buildPodfiltersArray($filter_id=0, $change_filters=[], $filters=[]){
    global $app;

    $result = [];

    if(isset($filters["parent_id"][$filter_id])){

       foreach ($filters["parent_id"][$filter_id] as $parent_value) {

          $items = [];

          $getItems = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$parent_value["id"],$change_filters[$filter_id]]);

          if($getItems){

             foreach ($getItems as $item) {
                 $ids_podfilter = $app->component->ads_filters->getParentIds($parent_value["id"]);               
                 $items[] = ["name"=>$item["name"], "id"=>$item["id"], "podfilter"=>$app->model->ads_filters_items->find("item_parent_id=?", [$item["id"]]) ? true : false, "ids_podfilter"=>$ids_podfilter ?: null];
             }

             $result[] = [
                 "id" => $parent_value["id"],
                 "view" => $parent_value["view"],
                 "name" => $parent_value["name"],
                 "items" => $items,
                 "required" => $parent_value["required"] ? true : false,
                 "podfilter" => $filters["parent_id"][$parent_value["id"]] ? true : false,
             ];

          }


          if(isset($change_filters[$parent_value["id"]])){

             $parent_filter = $this->buildPodfiltersArray($parent_value["id"], $change_filters, $filters);
             
             if($parent_filter){
                 $result = array_merge($result, $parent_filter);
             }

          }

       }

    }

    return $result ? $result : [];

 }

public function categoriesData($value=[]){
    global $app;

    $parent = $app->model->ads_categories->find("parent_id=? and status=?", [$value["id"],1]);

    $chain_array = $app->component->ads_categories->getParentsId($value["id"]);

    $breadcrumb = $app->component->ads_categories->getBuildNameChain($chain_array);

    return [
        "id"=>$value["id"],
        "name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
        "image"=>$app->storage->name($value["image"])->exist() ? $app->storage->name($value["image"])->host(true)->get() : null,
        "subcategory"=>$parent ? true : false,
        "breadcrumb"=>$breadcrumb,
    ];

}

public function decryptAES($text=null){
    global $app;

    $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', openssl_decrypt(base64_decode($text), 'AES-256-CTR', $app->config->api->encryption_key, OPENSSL_RAW_DATA, $app->config->api->encryption_iv));

    return base64_decode($result);

}

public function encryptAES($text=null){
    global $app;

    $encrypt = openssl_encrypt($text, "AES-256-CBC", $app->config->api->encryption_key, OPENSSL_RAW_DATA, $app->config->api->encryption_iv);

    return base64_encode($encrypt);

}

public function filtersRequired($filters = [], $category_id = 0){
     global $app;

     $result = [];

     $getIdFilters = $app->component->ads_filters->getFiltersByCategory($category_id);

     if($getIdFilters){

         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                if($value["required"]){

                    if($value["view"] == "input"){

                        $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                        
                        if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                            $result[] = translate("tr_e5a1dbbc446598bc2ae7b4ae3318ea76")." ".$value["name"]." ".translate("tr_7f164d12155a14bdb34181b6f8c41f3f")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                        }

                    }else{

                        if($value["parent_id"]){

                            if($filters[$value["parent_id"]][0]){ 

                                $filterItem = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$value["id"], $filters[$value["parent_id"]][0]]);

                                if($filterItem){
                                    if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                        $result[] = translate("tr_bd9b6163fccd3d74dcba6a2040d91bbb") . " " . $value["name"];

                                    }
                                }

                            }

                        }else{

                            if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                $result[] = translate("tr_bd9b6163fccd3d74dcba6a2040d91bbb") . " " . $value["name"];

                            }                            

                        }

                    }

                }else{

                    if($value["view"] == "input"){

                        if($filters[$value["id"]][0]){

                            $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                            
                            if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                                $result[] = translate("tr_e5a1dbbc446598bc2ae7b4ae3318ea76")." ".$value["name"]." ".translate("tr_7f164d12155a14bdb34181b6f8c41f3f")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                            }

                        }

                    }                        

                }

            }

         }

     }

     return $result;

}

public function fixStat($params=[]){
   global $app;

   if($params["session_id"]){

        $data = $app->model->mobile_stat->find("session_id=?", [$params["session_id"]]);

        if($data){
            $app->model->mobile_stat->update(["time_update"=>$app->datetime->getDate(), "user_id"=>$params["user_id"] ?: 0], ["session_id=?", [$params["session_id"]]]);
        }else{
            $app->model->mobile_stat->insert(["device_platform"=>$params["device_platform"] ?: null,"device_model"=>$params["device_model"] ?? null, "time_create"=>$app->datetime->getDate(), "time_update"=>$app->datetime->getDate(), "ip"=>$params["ip"] ?: null, "user_id"=>$params["user_id"] ?: 0, "session_id"=>$params["session_id"]]);
        }

   }
   
}

public function getCategoryOptions($category_id=0, $user_id=0, $change_filters=[]){
    global $app;

    $result["price_measurements"] = [];
    $result["price_currency_status"] = false;
    $result["term_date_status"] = false;
    $result["price_fixed_change_status"] = false;
    $result["price_gratis_status"] = false;
    $result["price_measurement_status"] = false;
    $result["delivery_status"] = false;
    $result["booking_status"] = $app->component->ads_categories->categories[$category_id]["booking_status"] ? true : false;
    $result["auto_title_status"] = $app->component->ads_categories->categories[$category_id]["filter_generation_title"] ? true : false;
    $result["online_view_status"] = $app->component->ads_categories->categories[$category_id]["online_view_status"] ? true : false;
    $result["condition_new_status"] = $app->component->ads_categories->categories[$category_id]["condition_new_status"] ? true : false;
    $result["condition_brand_status"] = $app->component->ads_categories->categories[$category_id]["condition_brand_status"] ? true : false;
    $result["category_paid"] = $app->component->ads_categories->categories[$category_id]["paid_status"] ? true : false;
    $result["category_paid_show_modal"] = $app->component->ads_categories->categories[$category_id]["paid_status"] ? true : false;
    $result["type_goods"] = $app->component->ads_categories->categories[$category_id]["type_goods"];
    $result["change_city_status"] = $app->component->ads_categories->categories[$category_id]["change_city_status"] ? true : false;
    $result["price_status"] = $app->component->ads_categories->categories[$category_id]["price_status"] ? true : false;
    $result["marketplace_status"] = $app->component->ads_categories->categories[$category_id]["marketplace_status"] ? true : false;
    $result['category_paid_answer'] = $this->outInfoPaidCategory($category_id, $user_id) ?: null;

    $result["booking_action"] = $app->component->ads_categories->categories[$category_id]["booking_action"];

    if($app->component->ads_categories->categories[$category_id]["delivery_status"] && $app->settings->integration_delivery_services_active){
        $result["delivery_status"] = true;
    }

    if($app->component->ads_categories->categories[$category_id]["price_status"]){

        $priceName = $app->model->system_price_names->find("id=?", [$app->component->ads_categories->categories[$category_id]["price_name_id"]]);

        if($priceName){
            $result["price_name"] = translateField($priceName->name);
        }else{
            $result["price_name"] = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }

        if($app->component->ads_categories->categories[$category_id]["price_measure_ids"]){
            $measurements = $app->model->system_measurements->getAll("id IN(".implode(",", _json_decode($app->component->ads_categories->categories[$category_id]["price_measure_ids"])).")");
            if($measurements){
                foreach ($measurements as $measurement) {
                    $result["price_measurements"][] = ["name"=>translateField($measurement["name"]),"value"=>$measurement["id"]];
                }
                $result["price_measurement_status"] = true;
            }
        }

        if($app->component->ads_categories->categories[$category_id]["price_fixed_change"]){
            $result["price_fixed_change_status"] = true;
        }

        if($app->component->ads_categories->categories[$category_id]["gratis_status"] && !$app->component->ads_categories->categories[$category_id]["price_required"]){
            $result["price_gratis_status"] = true;
        }

        if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){

            if($app->settings->system_extra_currency){

                foreach ($app->settings->system_extra_currency as $code) {
                    $result["price_currencies"][] = ["name"=>$app->system->getCurrencyByCode($code)->symbol,"code"=>$app->system->getCurrencyByCode($code)->code, "symbol"=>$app->system->getCurrencyByCode($code)->symbol];
                }

                $result["price_currency_status"] = true;

            }

        }

    }

    if($app->settings->board_publication_term_date_status){

        if($app->settings->board_publication_term_date_list){

            foreach (explode(",", $app->settings->board_publication_term_date_list) as $day) {
                $result["term_date_items"][] = ["name"=>$day.' '.endingWord($day, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),"value"=>$day];
            }

            $result["term_date_status"] = true;

        }

    }

    if($app->component->ads_categories->categories[$category_id]["booking_status"]){

       if($app->component->ads_categories->categories[$category_id]["booking_action"] == "booking"){

           $result["booking_title"] = translate("tr_63783067211bb3ccaeef2b6a42c8cb8a");
           
       }elseif($app->component->ads_categories->categories[$category_id]["booking_action"] == "rent"){

           $result["booking_title"] = translate("tr_4cde4557d1ec234515bdadfbbde9050a");

       }

       $result["booking_action"] = $app->component->ads_categories->categories[$category_id]["booking_action"];

    }

    $filters_id = $app->component->ads_filters->getFiltersByCategory($category_id);

    if($filters_id){

        $filters = $app->component->ads_filters->getFilters();

        $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);

        if($getFilters){

             foreach ($getFilters as $key => $value) {

                $items = [];

                $getItems = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);

                if($getItems){

                    foreach ($getItems as $item_value) {
                        $items[] = ["name"=>$item_value["name"], "id"=>$item_value["id"], "podfilter"=>$app->model->ads_filters_items->find("item_parent_id=?", [$item_value["id"]]) ? true : false];
                    }

                }

                $ids_podfilter = $app->component->ads_filters->getParentIds($value["id"]);

                $result["filters"][] = [
                    "id" => $value["id"],
                    "view" => $value["view"],
                    "name" => $value["name"],
                    "ids_podfilter"=> $ids_podfilter ? explode(",", $ids_podfilter) : null,
                    "items" => $items,
                    "required" => $value["required"] ? true : false,
                    "podfilter" => $filters["parent_id"][$value["id"]] ? true : false,
                ];

                if($change_filters[$value["id"]]){

                    $parent_filters = $this->buildPodfiltersArray($value["id"], $change_filters, $filters);

                    if($parent_filters){
                        $result["filters"] = array_merge($result["filters"], $parent_filters);
                    }

                }

             }

        }

    }

    return $result;

}

public function getSettings(){
    global $app;
    
    $delivery_list = [];
    $results = [];

    $results["project"]["name"] = $app->settings->api_app_project_name ?: $app->settings->project_name;
    $results["project"]["version"] = "1.5.0";

    $results["project"]["user_agreement_link"] = $app->settings->api_app_user_agreement_link ?: null;
    $results["project"]["privacy_policy_link"] = $app->settings->api_app_privacy_policy_link ?: null;

    $results["registration_bonus"] = ["status"=>$app->settings->registration_bonus_status ? true : false, "amount"=>$app->system->amount($app->settings->registration_bonus_amount), "title"=>translate("tr_1db128b783037ea56d0135eb79fb0fde")."\n".translate("tr_789ac98513f324da68f5b8ae1cdd32a7")." ".$app->system->amount($app->settings->registration_bonus_amount), "text"=>translate("tr_a73eb08f45a7ecec42a8fb7f3c15c41d"), "icon"=>"😍"];
    $results["fortune_bonus_status"] = $app->settings->api_app_fortune_bonus_status ? true : false;

    if($app->settings->api_app_fortune_bonus_items){
        $fortune_bonus_items = explode(",", $app->settings->api_app_fortune_bonus_items);
        if($fortune_bonus_items){
            foreach ($fortune_bonus_items as $key => $value) {
                $results["fortune_bonus_items"][] = round($value, 2);
            }
        }else{
            $results["fortune_bonus_items"] = null;
        }
    }else{
        $results["fortune_bonus_items"] = null;
    }

    $results["fortune_bonus_data"] = ["title"=>translate("tr_8079f64db75b7a781f92c944ffca629d"), "text"=>translate("tr_e65ffed32c2630c4ce50ab89e744e1c9"), "icon"=>"🤑"];

    $results["profile_notifications_messenger_status"] = $app->settings->profile_notifications_messenger_status ? true : false;
    $results["catalog_map_view_status"] = true;

    $results["default_phone"] = ["format"=>$app->system->getDefaultPhoneTemplate()->template, "icon"=>$app->storage->name($app->system->getDefaultPhoneTemplate()->icon)->host(true)->get(), "code"=>$app->system->getDefaultPhoneTemplate()->code];

    if($app->system->multiPhonesStatus()){
        $phones = $app->system->getPhones();
        if($phones){
            foreach ($phones as $key => $value) {
                $results["allowed_templates_phone_list"][] = ["name"=>$value->country, "format"=>$value->template, "icon"=>$app->storage->name($value->icon)->host(true)->get(), "code"=>$app->system->getDefaultPhoneTemplate()->code];
            }
        }
    }else{
        $results["allowed_templates_phone_list"] = null;
    }

    $results["main_currency"] = ["position"=>$app->settings->system_currency_position, "symbol"=>$app->system->getDefaultCurrency()->symbol, "code"=>$app->system->getDefaultCurrency()->code, "spacing"=>$app->settings->system_currency_spacing ? true : false];

    $results["user_verification_availability"] = $app->settings->verification_users_status ? true : false;
    $results["user_verification_code"] = mt_rand(1000000,9000000);
    
    if($app->settings->integration_payment_services_active){
        $payments = $app->model->system_payment_services->sort("id desc")->getAll("status=? and id IN(".implode(",", $app->settings->integration_payment_services_active).")", [1]);

        if($payments){
            foreach ($payments as $key => $value) {

                $results["payment_services"][] = ["image"=>$app->storage->name($value["image"])->host(true)->get() ?: null, "payment_id"=>$value["alias"], "name"=>$value["name"] ?: null, "subtitle"=>$value["title"] ?: null];

            }
        }
    }

    $results["payment_wallet_status"] = $app->settings->profile_wallet_status ? true : false;

    $payment = $app->component->transaction->getServiceSecureDeal();

    $results["payment_secure_data"] = ["desc"=>$payment->secure_description ?: null, "type_score"=>$payment->type_score, "type_score_name"=>$payment->type_score_name];

    $balance_amount_list = $app->settings->api_app_replenishment_balance_amount_list ? explode(",", $app->settings->api_app_replenishment_balance_amount_list) : [];
    if($balance_amount_list){
        foreach ($balance_amount_list as $key => $value) {
            $results["replenishment_balance_amount_list"][] = round($value, 2);
        }
    }else{
        $results["replenishment_balance_amount_list"] = null;
    }

    $results["user_notifications_method_list"][] = ["name"=>"Email", "method"=>"email"];
    $results["user_notifications_method_list"][] = ["name"=>"Telegram", "method"=>"telegram"];

    $results["ad_card_who_phone_view"] = $app->settings->board_card_who_phone_view;

    $results["create_ad"]["max_length_title"] = $app->settings->board_publication_max_length_title ?: 150;
    $results["create_ad"]["max_length_text"] = $app->settings->board_publication_max_length_text ?: 3000;
    $results["create_ad"]["count_photo"] = $app->settings->board_publication_limit_count_media ?: 30;
    $results["create_ad"]["add_video_status"] = $app->settings->board_publication_add_video_status ? true : false;
    $results["create_ad"]["currency_status"] = $app->settings->board_publication_currency_status ? true : false;
    $results["create_ad"]["term_date_status"] = $app->settings->board_publication_term_date_status ? true : false;
    $results["create_ad"]["required_contact_whatsapp"] = $app->settings->board_publication_required_contact_whatsapp ? true : false;
    $results["create_ad"]["required_contact_telegram"] = $app->settings->board_publication_required_contact_telegram ? true : false;
    $results["create_ad"]["required_contact_max"] = $app->settings->board_publication_required_contact_max ? true : false;

    $results["stories"]["allowed_extensions"] = ['jpg', 'png', 'heic', 'mp4', 'mov', 'quicktime'];
    $results["stories"]["video_length"] = $app->settings->stories_max_duration_video ?: 15;

    $results["geo_status"] = $app->component->geo->defaultCountry ? true : false;
    $results["geo_default_country"] = $this->buildArrayGeoDefaultCountry();

    $results["nav_bar_label_status"] = $app->settings->api_app_nav_bar_label_status ? true : false;
    $results["catalog_item_card"] = ["ad_rating_status"=>$app->settings->api_app_catalog_item_card["ad_rating_status"] ? true : false, "user_avatar_status"=>$app->settings->api_app_catalog_item_card["user_avatar_status"] ? true : false, "city_status"=>$app->settings->api_app_catalog_item_card["city_status"] ? true : false, "time_create_status"=>$app->settings->api_app_catalog_item_card["time_create_status"] ? true : false, "height_item_photo"=>$app->settings->api_app_catalog_item_card["height_item_photo"] ?: 200, "height_default_card"=> $app->settings->api_app_catalog_item_card["height_default_card"] ?: 160];
    $results["metrica_key"] = $app->settings->api_app_metrica_key ?: null;
    $results["basket_status"] = $app->settings->basket_status ? true : false;
    $results["multi_languages_status"] = $app->settings->multi_languages_status ? true : false;

    $results["confirmation_length_code"] = $app->settings->confirmation_length_code ?: 4;
    $results['confirmation_phone'] = true;
    $results['registration_authorization_method'] = $app->settings->registration_authorization_method; 

    $results["main_page_registration_box"] = $app->settings->api_app_main_page_registration_box ?: null;

    $results["main_page_header_banner"]["status"] = $app->settings->api_app_main_page_header_banner_status ? true : false;
    $results["main_page_header_banner"]["data"] = $app->settings->api_app_main_page_header_banner ?: null;

    $results["auth_social_status"] = false;
    $results['auth_social_list'][] = [];

    $getCategories = $app->model->ads_categories->getAll("parent_id=? and status=?", [0,1]);
    if($getCategories){
        foreach ($getCategories as $key => $value) {

            $results["main_categories"][] = $this->categoriesData($value);

        }
    }

    $results["start_promo_banners"]["status"] = $app->settings->api_app_start_promo_banners_status ? true : false;
    $results["start_promo_banners"]["data"] = $app->settings->api_app_start_promo_banners ? array_values($app->settings->api_app_start_promo_banners) : null;

    $results["main_page_slider_banners"]["status"] = $app->settings->api_app_main_page_slider_banners_status ? true : false;
    $results["main_page_slider_banners"]["data"] = $app->settings->api_app_main_page_slider_banners ? array_values($app->settings->api_app_main_page_slider_banners) : null;

    $results["main_page_promo_sections"]["status"] = $app->settings->api_app_main_page_promo_sections_status ? true : false;
    $results["main_page_promo_sections"]["data"] = $app->settings->api_app_main_page_promo_sections ? array_values($app->settings->api_app_main_page_promo_sections) : null;
    $results["main_page_promo_sections"]["view"] = $app->settings->api_app_main_page_promo_sections_view ?: "name";

    if($app->settings->api_app_main_page_tabs){
        foreach ($app->settings->api_app_main_page_tabs as $key => $value) {
            if($value == "recommendations"){
                $results["main_page_tabs"][] = ["id"=>$value, "name"=>translate("tr_558e9d04ead7e5b7039047030e62c975")];
            }elseif($value == "fresh"){
                $results["main_page_tabs"][] = ["id"=>$value, "name"=>translate("tr_b389ecd52e5647a02fd03b227839d694")];
            }elseif($value == "shops"){
                $results["main_page_tabs"][] = ["id"=>$value, "name"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f")];
            }
        }
    }

    $results["main_page_out_content"] = $app->settings->api_app_main_page_out_content ?: null;

    $languages = $app->model->languages->getAll("status=?", [1]);
    if($languages){
       foreach ($languages as $value) {

            if(file_exists($app->config->storage->translations . '/' . $value['iso'] . '/app.tr')){
                $content = require $app->config->storage->translations . '/' . $value['iso'] . '/app.tr';
            }else{
                $content = require $app->config->storage->translations . '/app.tr';
            }
            
            $results["list_languages"][] = ['name'=>$value['name'],'image'=>$app->storage->name($value["image"])->exist() ? $app->storage->name($value["image"])->get() : null,'iso'=>$value['iso']];
            $results["list_languages_iso"][$value['iso']] = ['name'=>$value['name'],'image'=>$app->storage->name($value["image"])->exist() ? $app->storage->name($value["image"])->get() : null,'iso'=>$value['iso'], 'content'=>$content];

       }
    }

    $getDefaultLanguage = $app->model->languages->find("iso=?", [$app->settings->default_language]);
    if($getDefaultLanguage){
        $results["default_language_iso"] = $getDefaultLanguage->iso;
        $results["default_language_locale"] = $getDefaultLanguage->locale ?: null;
    }else{
        $results["default_language_iso"] = "ru";
        $results["default_language_locale"] = null;
    }

    if(isset($app->settings->api_app_services_pages) && is_array($app->settings->api_app_services_pages)){
        $results["services_pages"] = array_values($app->settings->api_app_services_pages);
    }else{
        $results["services_pages"] = null;
    }

    if($app->settings->integration_delivery_services_active){
        $delivery = $app->model->system_delivery_services->getAll("status=? and id IN(".implode(",", $app->settings->integration_delivery_services_active).")", [1]);
        if($delivery){
            foreach ($delivery as $key => $value) {
                $delivery_list[] = ["id"=>$value["id"], "logo"=>$app->addons->delivery($value["alias"])->logo(), "name"=>$value["name"]];
            }
        }
    }

    $results["delivery_data"] = ["status"=>$app->settings->integration_delivery_services_active ? true : false, "list"=>$delivery_list, "recipient_middlename_status"=>true];

    if($app->settings->verification_users_status){
        if($app->settings->verification_users_permissions){
            foreach ($app->settings->verification_users_permissions as $key => $value) {
                $result["verification_users_permissions"][$value] = true;
            }
        }
    }

    
    return $results;
}

public function getStat(){
    global $app;
    
    return (object)["total_install"=>$app->model->mobile_stat->count(),"today_install"=>$app->model->mobile_stat->count("DATE(time_create)=?", [$app->datetime->format("Y-m-d")->getDate()]), "active_sessions"=>$app->model->mobile_stat->count("unix_timestamp(time_update) + 180 > unix_timestamp(now())"), "active_sessions_list"=>$app->model->mobile_stat->getAll("unix_timestamp(time_update) + 180 > unix_timestamp(now())")];
 }

public function getStatisticsInstallByMonthChart($filter_date=null){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    if($filter_date){
        $y = date("Y", strtotime($filter_date));
        $m = date("m", strtotime($filter_date));  
    }else{
        $y = $app->datetime->format("Y")->getDate();
        $m = $app->datetime->format("m")->getDate();            
    }

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        $totalCount = $app->model->mobile_stat->count("date(time_create)=?", [$date]);

        $action_count[translate("tr_268c84614442059ed8301431b06778f3")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>(int)$totalCount];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getTotalInstallByWeekChart(){   
    global $app;

    $data = [];

    $week[date('Y-m-d')] = date('Y-m-d');

    $currentWeek = date("w",strtotime(date('Y-m-d'))) == 0 ? 7 : date("w",strtotime(date('Y-m-d')));

    if($currentWeek > 1){
        $x=0;
        while ($x++<$currentWeek-1){
           $week[date('Y-m-d', strtotime("-".$x." day"))] = date('Y-m-d', strtotime("-".$x." day"));
        }
    }

    foreach ($week as $key => $value) {
        $count = $app->model->mobile_stat->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$count, "title"=>$count.' '.endingWord($count, translate("tr_ab8ae40ed581a0f7351007933de08729"), translate("tr_25273d0cf4eaea6ebc552ce62053d6f5"), translate("tr_b9e0be33837ac2d6468a62bd6cbf05d4"))];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}

function normalizedFiltersAllItemsArray($filters=[]){
     $results = [];
     if($filters){
         foreach ($filters as $key => $value) {

            if($value['field'] == "start"){
               if($value['item']) $results[intval($value['filterId'])]["from"] = $value['item'];
            }elseif($value['field'] == "end"){
               if($value['item']) $results[intval($value['filterId'])]["to"] = $value['item'];
            }elseif($value['field'] == "text"){
               if($value['item']) $results[intval($value['filterId'])][] = $value['item'];
            }else{
               if($value['item']) $results[intval($value['filterId'])][] = $value['item'];
            }
            
            
         }
     }
     return $results;
 }

function normalizedFiltersArray($filters=[]){
    $results = [];
    if($filters){
        foreach ($filters as $key => $value) {
           if($value['item']) $results[intval($value['filterId'])] = $value['item'];
        }
    }
    return $results;
}

function normalizedFiltersCatalogArray($filters=[]){
    $results = [];
    if($filters){
        foreach ($filters as $key => $value) {
           if($value['item']) $results[intval($value['filterId'])][] = $value['item'];
        }
    }
    return $results;
}

public function normalizedMediaArray($media=[]){

    $result = [];

    if($media){

        foreach ($media as $key => $value) {
            $info = pathinfo($value["link"]);
            if($value["type"] == "image" || $value["type"] == "video"){
                $result[][$value["type"]] = $info["filename"];
            }
        }

    }

    return $result;

}

public function outInfoPaidCategory($category_id=0, $user_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){

        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            if($app->component->ads->getCountFreePublicationsByUser($user_id, $category_id) >= (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"]){

                return translate("tr_e7a1c347a5499e07ddb193041121d536")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);

            }else{

                return translate("tr_df0ef1856bbdb1391833422d6e4b9cae")." ".$app->component->ads->getRemainedCountFreePublicationsByUser($user_id, $category_id)." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
            }
            
        }else{
            return translate("tr_c91ec5934a89a80809ec4d183fb441d3")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
        }

    }

}

public function outInfoPaymentsOrderDeal($order_id=0, $user_id=0){
    global $app;

    $getPayment = $app->model->transactions_deals_payments->find("order_id=? and whom_user_id=?", [$order_id, $user_id]);

    if($getPayment){
        if($getPayment->status_processing == "awaiting_payment"){

            return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 

        }elseif($getPayment->status_processing == "done"){

            return $app->system->amount($getPayment->amount) . ' ' . translate("tr_95231d935ffb9f48fd901c46e92676f7");

        }elseif($getPayment->status_processing == "no_score"){

            return translate("tr_ca6482e97550b5bd24f16d04d7e711a5");

        }elseif($getPayment->status_processing == "payment_error"){

            if($getPayment->comment && $getPayment->user_show_error){
                return $getPayment->comment; 
            }else{
                return $app->system->amount($getPayment->amount).' '.translate("tr_e583db0168523757a8bc054e9a2db4e9"); 
            }

        }
    }

}

public function outPostContent($data=[]){
    global $app;

    $result = [];

    if($data->content){

        foreach (_json_decode(translateFieldReplace($data, "content", $_REQUEST["lang_iso"])) as $key => $nested) {
            foreach ($nested as $type => $value) { 
                
                if($type == "image"){

                    $result[] = ' <img src="'.$app->storage->name($value)->host(true)->get().'" >';

                }elseif($type == "link_video"){

                    $video = $app->video->parseLinkSource($value);

                    if($video){
                        $result[] = '
                             <iframe
                                src="'.$video->link.'"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                              ';
                    }else{
                        $result[] = '
                             <iframe
                                src="'.$value.'"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                              ';                            
                    }
                    
                }elseif($type == "text"){

                    $result[] = $value;
                    
                }elseif($type == "code"){
                    
                    $result[] = $value;

                }elseif($type == "separator"){
                    
                    $result[] = '<hr>';

                }

            }
        }

    }

    return implode("", $result);

}

public function outPriceAndCurrency($data=[]){
    global $app;

    $data = (array)$data;

    $measure_title = '';

    if($data["price_gratis_status"]){
        return translate("tr_60183c67d880a855d91a9419f344e97e");
    }

    if($data["price"]){

        $measure = $app->model->system_measurements->find("id=?", [$data["price_measure_id"]]);

        if($measure){
            $measure_title = translate("tr_462eaa68988f6a1a10814f865d5160ad").' '.translateField($measure->name);
        }

        if($data["price_fixed_status"]){

            return $app->system->amount($data["price"], $data["currency_code"]).' '.$measure_title;

        }else{

            return translate("tr_7f164d12155a14bdb34181b6f8c41f3f").' '.$app->system->amount($data["price"], $data["currency_code"]).' '.$measure_title;

        }

    }

    return translate("tr_8d7254e709bd2fbc45c82c02d6d1e269");

}

public function price($data=[]){
    global $app;

    return ["now"=>$this->outPriceAndCurrency($data["ad"]), "old"=>$data["ad"]->old_price ? $app->system->amount($data["ad"]->old_price, $data["ad"]->currency_code) : null];
}

public function reviewData($value=[]){
    global $app;

    $user = $app->model->users->find("id=?", [$value['from_user_id']]);
    $ad = $app->component->ads->getAd($value["item_id"]);

    return [
        "id" => $value['id'],
        "rating" => $value['rating'],
        "item_title" => $ad->title,
        "media"=>_json_decode($value['media']),
        "text" => html_entity_decode($value['text']),
        "from_user" => [
            "display_name"=>$app->user->name($user),
            "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
        ], 
    ];

}

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

public function searchCity($query=null, $country_id=0){
    global $app;

    $result = [];

    $country_id = $country_id ?: $app->component->geo->defaultCountry->id;

    if(_mb_strlen($query) < 2 || !$app->settings->active_countries){
        return [];
    }

    if($query){

        $cities = $app->model->geo_cities->cacheKey(["search"=>$query, "country_id"=>$country_id])->search($query)->sort("name asc limit 100")->getAll("country_id=?", [$country_id]);

        if($cities){
            foreach ($cities as $key => $value) {
                $result[] = ["name"=>$app->component->geo->outFullNameCity($value), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>$value["name"], "region_name"=>translateFieldReplace($value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$value["id"], "region_id"=>$value["region_id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
            }
        }

    }

    return $result;

}

public function searchGeoCombined($query=null, $country_id=0){
    global $app;

    $result = [];
    $regions_ids = [];

    if(!$app->settings->active_countries){
        return [];
    }

    $country_id = $country_id ?: $app->component->geo->defaultCountry->id;

    if($country_id){
        $country = $app->model->geo_countries->find("id=? and status=?", [$country_id, 1]);
        if(!$country){
            return [];
        }
    }

    if(isset($query)){

        $query_fields[] = 'name';

        if($app->translate->fieldReplace("name")){
            $query_fields[] = $app->translate->fieldReplace("name");
        }

        $getCities = $app->model->geo_cities->cacheKey(["query"=>$query, "country_id"=>$country_id, "status"=>1])->search($query, $query_fields)->sort("name asc limit 50")->getAll("country_id=? and status=?", [$country_id,1]);

        if($getCities){

            foreach ($getCities as $key => $value) {

                $result[] = ["name"=>$app->component->geo->outFullNameCity($value), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "city_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "region_name"=>translateFieldReplace($value, "region_name", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>$value["id"], "region_id"=>$value["region_id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];

                if($value["region_id"]){
                    $regions_ids[] = $value["region_id"];
                }

            }

            if($regions_ids){

                $getRegions = $app->model->geo_regions->cacheKey(["id"=>implode(",",$regions_ids)])->sort("name asc")->getAll("id IN(".implode(",",$regions_ids).")");

                if($getRegions){

                    foreach ($getRegions as $key => $value) {
                        $result[] = ["name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>0, "region_id"=>$value["id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
                    }

                }

            }

        }else{

            $getRegions = $app->model->geo_regions->cacheKey(["query"=>$query, "country_id"=>$country_id, "status"=>1])->search($query, $query_fields)->sort("name asc limit 50")->getAll("country_id=? and status=?", [$country_id,1]);

            if($getRegions){

                foreach ($getRegions as $key => $value) {

                    $result[] = ["name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "geo_name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($value, "declension", $_REQUEST["lang_iso"]) ?: null, "country_name"=>translateFieldReplace($value, "country_name", $_REQUEST["lang_iso"]), "city_id"=>0, "region_id"=>$value["id"], "country_id"=>$value["country_id"], "lat"=>$value["latitude"] ?: null, "lon"=>$value["longitude"] ?: null];
  
                }

            }

        }

    }

    return $result;

}

public function shopData($value=[]){
    global $app;

    $ads_images = [];

    $user = $app->model->users->find("id=?", [$value["user_id"]]);

    $countAds = $app->model->ads_data->count("user_id=? and status=?", [$value["user_id"], 1]);
    $getSliceAds = $app->model->ads_data->getAll("user_id=? and status=? order by id desc limit 30", [$value["user_id"], 1]);

    if($getSliceAds){
        shuffle($getSliceAds);
        foreach ($getSliceAds as $ad) {
            $array_images = $app->component->ads->getMedia($ad["media"]);
            $ads_images[] = $array_images->images->first;
        }
    }

    return [
        "id" => $value['id'],
        "title" => html_entity_decode($value['title']),
        "text" => html_entity_decode($value['text']),
        "logo" => $app->storage->name($value["image"])->host(true)->get(),
        "count_ads" => $countAds .' '.endingWord($getCountAds, translate("tr_9d928c2189f3ae48a5f8564491674a93"), translate("tr_d698d30efcc1e36c5ad2ded581b2f8ee"), translate("tr_6c851bdebb2c3d43cc0a06bc61fef96d")),
        "count_ads_int" => $countAds,
        "ads_images" => $ads_images ?: null,
        "user" => [
            "id"=>$value["user_id"],
            "total_rating"=>$user->total_rating ?: '0',
            "total_reviews"=>$user->total_reviews ?: '0',
            "show_rating"=>$user->total_rating ? true : false,
        ], 
    ];

}

public function statusNameAd($status=0){

    if($status == 0){
        return translate("tr_d9d74d385363cf3fdf9c1e62b484acca");
    }elseif($status == 1){
        return translate("tr_87a4286b7b9bf700423b9277ab24c5f1");
    }elseif($status == 2){
        return translate("tr_76c7531608b05ea0f6382db8e63a9ed4");
    }elseif($status == 3){
        return translate("tr_a15517a088054a2abd7af60c8a6462fb");
    }elseif($status == 4){
        return translate("tr_b6c10e7546945122976732d133e2d28a");
    }elseif($status == 5){
        return translate("tr_91254e7aa5a4b54e7cfb59ebab246f44");
    }elseif($status == 6){
        return translate("tr_24ab16e4706692efe2de13348b879007");
    }elseif($status == 7){
        return translate("tr_5890c2583af9a6b327d4d51f828678e7");
    }elseif($status == 8){
        return translate("tr_9e1ad28d8e86e5df9b53cb1f360e7114");
    }

}

public function storiesPublication($params=[], $user_id=0){
    global $app;

    $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

    if(!$tariff->items->add_stories){
        return json_answer(["status"=>false]);
    }

    $media = $app->component->stories->uploadMedia($params['name'], $params['type']);

    if(!$media){
        return ["status"=>false, "answer"=>translate("tr_8b1269c207872d7f783a4fe90ecf0ecb")];
    }

    if($app->settings->stories_moderation_status){
        $status = 0;
    }else{
        $status = 1;
    }

    if($params['type'] == "image"){
        $duration = $app->settings->stories_max_duration_image;
    }else{
        if($params["video_duration"]){
            $duration = $params["video_duration"] <= $app->settings->stories_max_duration_video ? $params["video_duration"] : $app->settings->stories_max_duration_video;
        }else{
            $duration = $app->settings->stories_max_duration_video;
        }
    }

    if($tariff->items->stories_3_days){
        $time_expiration = $app->datetime->addDay(3)->getDate();
    }elseif($tariff->items->stories_7_days){
        $time_expiration = $app->datetime->addDay(7)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $getStory = $app->model->stories->find("user_id=?", [$user_id]);

    if($getStory){

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

       $app->model->stories->update(["time_create"=>$app->datetime->getDate()], ["user_id=?", [$user_id]]);

    }else{

       $app->model->stories->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate()]);

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

    }

    $app->event->addStories(["user_id"=>$user_id]);

    if($app->settings->stories_moderation_status){
        return ["status"=>true, "answer"=>translate("tr_bd3b3e8aec6a731f69092d1dc03fd0ea")];
    }else{
        return ["status"=>true, "answer"=>translate("tr_86c67ada3b0abc338f70d5e887c81c0d")];
    }

}

public function updateActiveStat($session_id=0){
    global $app;

    if($session_id){

         $app->model->mobile_stat->update(["time_update"=>$app->datetime->getDate()], ["session_id=?", [$session_id]]);

    }
    
 }

public function userActivityStatus($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return true;
        }else{
            return false;
        }
    }
    return false;
}

public function userData($user=[]){
        global $app;

        $shop = [];

        $shop = $app->component->shop->getActiveShopByUserId($user->id);
        $countAds = $app->model->ads_data->count("user_id = ? and status = ?", [$user->id,1]);
        $countSubscribers = $app->model->users_subscriptions->count("whom_user_id = ?", [$user->id]);
        
        return [
            "id" => $user->id,
            "display_name" => $user->name,
            "name" => $user->name,
            "surname" => $user->surname,
            "contacts" => $contacts ?: null,
            "organization_name" => $user->organization_name ?: "",
            "user_status" => $user->user_status == 1 ? "user" : "company",
            "alias" => $user->alias,
            "avatar" => $app->storage->name($user->avatar)->host(true)->get(),
            "rating" => sprintf("%.1f", $user->total_rating),
            "reviews" => $user->total_reviews,
            "reviews_label" => $user->total_reviews . " " . endingWord($user->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")),
            "uniq_hash" => $user->uniq_hash,
            "status" => $user->status,
            "mode_online" => $this->userActivityStatus($user->time_last_activity),
            "shop" => $shop ? [
                "id"=>$shop->id,
                "title"=>$shop->title,
                "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                "text"=>$shop->text,
            ] : null,
            "verification_status" => $user->verification_status ? true : false,
            "balance" => $user->balance,
            "balance_formatted" => $app->system->amount($user->balance),
            "tariff" => $this->usersServiceTariffData($user->id, $user->tariff_id) ?: null,
            "count_ads" => $countAds,
            "subscribers_count" => $countSubscribers,
            "orders" =>null,
            "ref_programm" => null,
            "tariff_id" => $user->tariff_id,
            "stories" => $this->usersStoriesData($user->id) ?: null,
            "status_text" => $user->card_status_text ?: null,
            "delivery_status" => $user->delivery_status, 
        ];
    }

public function userFullData($user=[]){
    global $app;

    $favorites = [];
    $shop = [];
    $orders = [];

    $getFavorites = $app->model->users_favorites->getAll("user_id=?", [$user->id]);

    if($getFavorites){
        foreach ($getFavorites as $value) {
            $favorites[] = $value["ad_id"];
        }
    }

    $getOrders = $app->model->transactions_deals->sort("time_update desc")->getAll("(from_user_id=? or whom_user_id=?) and status_completed=? and status_processing!=?", [$user->id, $user->id, 0, "cancel_order"]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {

            $orders[] = [
                "id"=>$value["id"],
                "order_id"=>(String)$value["order_id"],
                "title"=>translate("tr_4d406f4dcd44a95252f06163a3cdcb5e")." ".$app->datetime->outDate($value["time_create"])." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$app->system->amount($value["amount"]),
                "status"=>$value["status_processing"],
                "status_name"=>$app->component->transaction->getStatusDeal($value["status_processing"])->name,
                "from_user_id"=>$value["from_user_id"],
                "whom_user_id"=>$value["whom_user_id"],
            ];

        }
    }

    $shop = $app->model->shops->find("user_id=?", [$user->id]);
    $countAds = $app->model->ads_data->count("user_id = ? and status = ?", [$user->id,1]);
    $countSubscribers = $app->model->users_subscriptions->count("whom_user_id = ?", [$user->id]);

    $notifications = $user->notifications ? _json_decode($user->notifications) : [];
    $contacts = $user->contacts ? _json_decode(decrypt($user->contacts)) : [];

    $payments = $app->model->users_payment_data->getAll("user_id=?", [$user->id]);
    if($payments){
        foreach ($payments as $key => $value) {
            $value["score"] = decrypt($value["score"]);
            $payments_score_list[] = ["id"=>$value["id"], "default_status"=>$value["default_status"] ? true : false, "score"=>"**** **** **** ".substr($value["score"], strlen($value["score"])-4, strlen($value["score"]))];
        }
    }

    $points = $app->model->users_shipping_points->getAll("user_id=?", [$user->id]);

    if($points){
        foreach ($points as $key => $value) {
           $delivery = $app->model->system_delivery_services->find("id=?", [$value["delivery_id"]]);
           if($delivery){
               $shipping_points[] = ["logo"=>$app->addons->delivery($delivery->alias)->logo(), "name"=>$delivery->name, "address"=>$value["address"]];
           }
        }
    }

    $getBonuses = $app->model->users_bonuses_fortune->find("user_id=? order by time_create desc", [$user->id]);

    if($getBonuses){
        $fortune_bonus_status = date("Y-m-d", strtotime($getBonuses->time_create)) == date("Y-m-d") ? false : true;
        $time = strtotime(date('d.m.Y 23:59'));
        $diff = $time - time();
        $fortune_bonus_remained_time = $diff;
    }else{
        $fortune_bonus_status = true;
        $fortune_bonus_remained_time = null;
    }

    $deliveryData = $app->model->users_delivery_data->find("user_id=?", [$user->id]);

    return [
        "id" => $user->id,
        "display_name" => $user->name,
        "name" => $user->name,
        "surname" => $user->surname,
        "password" => $user->password ?: null,
        "notifications_method" => $user->notifications_method,
        "notifications_list" => $notifications ? ["chat"=>$notifications["chat"] ? true : false, "expiration_ads"=>$notifications["expiration_ads"] ? true : false, "expiration_tariff"=>$notifications["expiration_tariff"] ? true : false] : null,
        "uniq_hash" => $user->uniq_hash,
        "messenger_notification_link" => ["telegram"=>outUserLinkTelegramBot($user->uniq_hash)],
        "contacts" => ["email"=>$user->email ? $this->encryptAES($user->email) : null, "phone"=>$user->phone ? $this->encryptAES($user->phone) : null, "whatsapp"=>$contacts["whatsapp"] ? $this->encryptAES($contacts["whatsapp"]) : null, "telegram"=>$contacts["telegram"] ? $this->encryptAES($contacts["telegram"]) : null, "max"=>$contacts["max"] ? $this->encryptAES($contacts["max"]) : null],
        "organization_name" => $user->organization_name ?: "",
        "user_status" => $user->user_status == 1 ? "user" : "company",
        "alias" => $user->alias,
        "avatar" => $app->storage->name($user->avatar)->host(true)->get(),
        "rating" => sprintf("%.1f", $user->total_rating),
        "reviews" => $user->total_reviews,
        "reviews_label" => $user->total_reviews . " " . endingWord($user->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")),
        "uniq_hash" => $user->uniq_hash,
        "status" => $user->status,
        "mode_online" => $this->userActivityStatus($user->time_last_activity),
        "shop" => $shop ? [
            "id"=>$shop->id,
            "title"=>$shop->title,
            "logo"=>$app->storage->name($shop->image)->host(true)->get(),
            "text"=>$shop->text,
        ] : null,
        "verification_status" => $user->verification_status ? true : false,
        "balance" => $user->balance,
        "balance_formatted" => $app->system->amount($user->balance),
        "tariff" => $this->usersServiceTariffData($user->id, $user->tariff_id) ?: null,
        "count_ads" => $countAds,
        "subscribers_count" => $countSubscribers,
        "orders" =>$orders ?: null,
        "ref_programm" => null,
        "tariff_id" => $user->tariff_id,
        "stories" => $this->usersStoriesData($user->id) ?: null,
        "favorites_ids" => $favorites?:null,
        "status_text" => $user->card_status_text ?: null,
        "delivery_status" => $user->delivery_status ? true : false,
        "ref_programm" => $app->settings->referral_program_status ? ["text"=>translate("tr_7cfdcea83842225d7c79b2b4b46a37eb")." ".$app->settings->referral_program_percent_award.translate("tr_db52586c384d927c18692bc5f5672950"), "link"=>getHost() . '/ref/' . $user->alias] : null,
        "payments_score_list" => $payments_score_list ?: [],
        "shipping_points" => $shipping_points ?: [],
        "fortune_bonus_status" => $fortune_bonus_status ? true : false,
        "fortune_bonus_remained_time" => $fortune_bonus_remained_time,
        "delivery_data"=>$deliveryData ? ["name"=>$deliveryData->name, "surname"=>$deliveryData->surname, "phone"=>$this->encryptAES(decrypt($deliveryData->phone)), "email"=>$this->encryptAES(decrypt($deliveryData->email))] : null,
    ];
}

public function userStoriesData($user_id=0){
    global $app;

    $result = [];

    $user = $app->model->users->findById($user_id);

    if(!$user){
        return [];
    }

    $shop = $app->component->shop->getActiveShopByUserId($user_id);

    $getUserStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("user_id=? and status=?", [$user_id, 1]);

    if($getUserStoriesMedia){
        foreach ($getUserStoriesMedia as $key => $value) {

            $ad = [];
            $media = _json_decode($value["media"]);

            if($value["item_id"]){
                $ad = $app->component->ads->getAd($value["item_id"]);
            }

            $count = $app->model->stories_media_views->count("story_id=?", [$value["id"]]);

            $result[] = [
                "id"=>$value["id"], 
                "image"=>$media["type"] == "image" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : $app->storage->path("user-attached")->name($media["folder"]."/".$media["preview"])->host(true)->get(),
                "link"=>$media["type"] == "video" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : null,
                "timestamp"=>strtotime($value["time_create"]), 
                "status"=>$value["status"], 
                "count_view"=>$count . ' ' . endingWord($count, translate("tr_f43eede2d635af40f32a2b21c42daa45"), translate("tr_bd99f22dcfb3422bf42ca4767607d427"), translate("tr_9636280c1189c0e4d5ac17cc03cc6af3")), 
                "type"=>$media["type"], 
                "duration"=>$value["duration"] ?: 30,
                "ad"=> $ad ? ["id"=>$value["item_id"], "title"=>$ad->title, "image"=>$ad->media->images->first, "price"=>$this->price(["ad"=>(array)$ad])] : null, 
                "user"=>[
                    "id"=>$user->id,
                    "name"=>$app->user->name($user),
                    "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
                ],
                "shop" => $shop ? [
                    "id"=>$shop->id,
                    "title"=>$shop->title,
                    "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                    "text"=>$shop->text,
                ] : null
            ];

        }
    }

    return $result;

}

public function usersServiceTariffData($user_id=0, $tariff_id=0){
    global $app;

    $items = [];
    $order = (object)[];

    if($tariff_id){

        $tariff = $app->model->users_tariffs->find("id=?", [$tariff_id]);

        if($tariff){

            $order = $app->model->users_tariffs_orders->find("user_id=?", [$user_id]);

            if($order){

                if(strtotime($order->time_expiration) > time() || $order->time_expiration == null){

                    $order->expiration_status = true;

                    $order->expiration_date = translate("tr_bec32eadbabac6fae71dbe1b9e4912bc") . ' ' . date("d.m.Y", strtotime($order->time_expiration));

                    if($tariff->items_id){
                        $items = $app->model->users_tariffs_items->getAll("id IN(".implode(",", _json_decode($tariff->items_id)).")");
                        if($items){
                            foreach ($items as $value) {
                                $order->items[$value["code"]] = true;
                            }
                        }
                    }

                }else{
                    $order->expiration_status = false;
                }

                $order->data = (array)$tariff;
                return (array)$order;

            }else{
                $order = (object)[];
                $order->data = (array)$tariff;
                $order->expiration_status = false;
            }

        }

    }

    return (array)$order;

}

public function usersStoriesData($user_id=0){
    global $app;

    $result = [];
    $stories = [];

    if($user_id){
        $getUsersStories = $app->model->stories->getAll("user_id=?", [$user_id]);
    }else{
        $getUsersStories = $app->model->stories->sort("time_create desc limit 50")->getAll();
    }

    if($getUsersStories){
        foreach ($getUsersStories as $key => $value) {

            $stories = [];

            $user = $app->model->users->findById($value['user_id']);

            $shop = $app->component->shop->getActiveShopByUserId($value['user_id']);

            $getUserStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("status=? and user_id=?", [1, $value["user_id"]]);

            if($getUserStoriesMedia){

                foreach ($getUserStoriesMedia as $story_key => $story_value) {

                    $ad = [];
                    $media = _json_decode($story_value["media"]);

                    if($story_value["item_id"]){
                        $ad = $app->component->ads->getAd($story_value["item_id"]);
                    }

                    $count = $app->model->stories_media_views->count("story_id=?", [$story_value["id"]]);

                    $stories[] = [
                        "id"=>$story_value["id"], 
                        "image"=>$media["type"] == "image" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : $app->storage->path("user-attached")->name($media["folder"]."/".$media["preview"])->host(true)->get(),
                        "link"=>$media["type"] == "video" ? $app->storage->path("user-attached")->name($media["folder"]."/".$media["name"])->host(true)->get() : null,
                        "timestamp"=>strtotime($story_value["time_create"]), 
                        "status"=>$story_value["status"], 
                        "count_view"=>$count . ' ' . endingWord($count, translate("tr_f43eede2d635af40f32a2b21c42daa45"), translate("tr_bd99f22dcfb3422bf42ca4767607d427"), translate("tr_9636280c1189c0e4d5ac17cc03cc6af3")), 
                        "type"=>$media["type"], 
                        "duration"=>$story_value["duration"] ?: 30, 
                        "ad"=> $ad ? ["id"=>$story_value["item_id"], "title"=>$ad->title, "image"=>$ad->media->images->first, "price"=>$this->price(["ad"=>(array)$ad])] : null
                    ];

                }

                $result[] = [
                    "id"=>$value["user_id"],
                    "name"=>$app->user->name($user),
                    "avatar"=>$app->storage->name($user->avatar)->host(true)->get(),
                    "timestamp"=>strtotime($value["time_create"]),
                    "items"=>$stories ?: null,
                    "shop" => $shop ? [
                        "id"=>$shop->id,
                        "title"=>$shop->title,
                        "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                        "text"=>$shop->text,
                    ] : null                        
                ];

            }

        }
    }

    return $result;

}

public function validationStepCreate($params=[], $user_id=0, $step=null, $update=false){
    global $app;

    $answer = [];

    $category_id = (int)$params['category_id'];

    if(!$app->component->ads_categories->categories[$category_id]){
        return null;
    }

    $user = $app->model->users->find("id=?", [$user_id]);

    if($step == 1 || $step == null){

        if(!$app->component->ads_categories->categories[$category_id]["filter_generation_title"]){
            if($app->validation->requiredField($params['title'])->status == false){
                $answer[] = translate("tr_a7f8a505c03860819c69c3f9c13ac37f");
            }else{
                if($app->validation->correctLength($params['title'],$app->settings->board_publication_min_length_title,$app->settings->board_publication_max_length_title)->status == false){
                    $answer[] = translate("tr_f2212de15734ed39aa5b0f099c88743f") . " " . $app->settings->board_publication_min_length_title . " " . translate("tr_538dc63d3c6db1a1839cafbaf359799b") . " " . $app->settings->board_publication_max_length_title . " " . translate("tr_8dd2b69669960646469fbeb70b2005fd");
                }
            }
        }

        if($app->validation->requiredField($params['text'])->status == false){
            $answer[] = translate("tr_b42fda28c3163fbcea01eb354ad77ba6");
        }else{
            if($app->validation->correctLength($params['text'],$app->settings->board_publication_min_length_text,$app->settings->board_publication_max_length_text)->status == false){
                $answer[] = translate("tr_cb1c35ba8ed57e2de1505d2e825348d3") . " " . $app->settings->board_publication_min_length_text . " " . translate("tr_538dc63d3c6db1a1839cafbaf359799b") . " " . $app->settings->board_publication_max_length_text . " " . translate("tr_8dd2b69669960646469fbeb70b2005fd");
            }
        }

        if($app->settings->board_publication_only_photos){
            if(!$params['media']){
                $answer[] = translate("tr_bb9a5a0b8f814f37cdb561d15a26bdf6");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["type_goods"] == "electronic_goods"){
            if($app->validation->requiredField($params['external_content'])->status == false){
                $answer[] = translate("tr_0eebdddf6afc16de5938ae0c8cf0313c");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["type_goods"] == "partner_link"){
            if($app->validation->requiredField($params['partner_link'])->status == false){
                $answer[] = translate("tr_8b21c9f272561a529bcf9b750841afa6");
            }
        }

        if($app->component->ads_categories->categories[$category_id]["change_city_status"] && $app->settings->active_countries){

            if($app->validation->requiredField($params['geo_city_id'])->status == false){
                $answer[] = translate("tr_7dfe7a8f465fe0769c414fc3f21278c6");
            }else{
                if(!$app->component->geo->getCityData($params['geo_city_id'])){
                    $answer[] = translate("tr_7dfe7a8f465fe0769c414fc3f21278c6");
                }
            }

        }

    }

    if($step == 2 || $step == null){

        if($app->component->ads_categories->categories[$category_id]["price_status"]){

            if($app->component->ads_categories->categories[$category_id]["price_required"]){
                if($app->validation->requiredFieldPrice($params['price'])->status == false){
                    $answer[] = translate("tr_bcf614572f9cb39274d6bbc3f73abe55");
                }
                if($app->component->ads_categories->categories[$category_id]["price_measure_ids"]){
                    if(count(_json_decode($app->component->ads_categories->categories[$category_id]["price_measure_ids"])) > 1){
                        if($app->validation->requiredField($params['price_measurement'])->status == false){
                            $answer[] = translate("tr_8f4100a8f642ff72b34d1181415b86bd");
                        }
                    }
                }
                if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){
                    if($app->validation->requiredField($params['price_currency_code'])->status == false){
                        $answer[] = translate("tr_99fe6d8bfc9a5c3b37a13185b26b0a56");
                    }
                }
            }else{
                if($app->validation->requiredFieldPrice($params['price'])->status == true){
                    if($app->component->ads_categories->categories[$category_id]["price_measure_ids"]){
                        if(count(_json_decode($app->component->ads_categories->categories[$category_id]["price_measure_ids"])) > 1){
                            if($app->validation->requiredField($params['price_measurement'])->status == false){
                                $answer[] = translate("tr_8f4100a8f642ff72b34d1181415b86bd");
                            }
                        }
                    }
                    if($app->settings->board_publication_currency_status){
                        if($app->validation->requiredField($params['price_currency_code'])->status == false){
                            $answer[] =  translate("tr_99fe6d8bfc9a5c3b37a13185b26b0a56");
                        }
                    }                
                }            
            }

        }

        if($update == false){
        
            if($app->settings->board_publication_term_date_status){
                if($app->validation->requiredField($params['term_date_day'])->status == false){
                    $answer[] = translate("tr_9e421a29c146e4013464613852719927");
                }            
            }

        }

        $requiredFilters = $this->filtersRequired($params['filters'], $category_id);

        if($requiredFilters){
            foreach ($requiredFilters as $key => $value) {
                $answer[] = $value;
            }
        }

        if($app->component->ads_categories->categories[$category_id]["booking_status"]){

            if($params['booking_deposit_status']){
                if($app->validation->requiredField($params['booking_deposit_amount'])->status == false){
                    $answer[] = translate("tr_40bca3fb1594f0af8ec5d197f1cfb73f");
                }                
            }

            if(!$params['booking_full_payment_status']){
                if($app->validation->requiredField($params['booking_prepayment_percent'])->status == false){
                    $answer[] = translate("tr_23255f6433c0878203899dfa1c15c2f6");
                }                
            }


        }

    }

    if($step == 3 || $step == null){

        if($app->validation->requiredField($params['contact_method'])->status == false){
            $answer[] = translate("tr_42267bbfa09b11b07a76674985f07875");
        }

        if($app->settings->board_publication_required_email){

            if($app->validation->isEmail($params['contact_email'])->status == false){
                $answer[] = translate("tr_3e3b7d9fb90cbdb9146fcff444b8ebe3");
            }else{
                if($app->settings->email_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$params["contact_email"], $user_id]) && $user->email != $params["contact_email"]){
                        $answer[] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                    } 
                }           
            }

        }

        if($app->settings->board_publication_required_phone_number){

            if($app->validation->isPhone($params['contact_phone'])->status == false){
                if($params['contact_method'] != "message"){
                    $answer[] = translate("tr_524283064f10cdddf715075cb1f5a2bb");
                }
            }else{
                if($app->settings->phone_confirmation_status){
                    if(!$app->model->users_verified_contacts->find("contact=? and user_id=?", [$app->clean->phone($params["contact_phone"]), $user_id]) && $user->phone != $app->clean->phone($params["contact_phone"])){
                        $answer[] = translate("tr_92899cea85e05d5f506efb774dfd87a3");
                    } 
                }
            }

        }

        if($app->validation->requiredField($params['contact_name'])->status == false){
            $answer[] = translate("tr_3e8d97ffba2a26223318e731b3550174");
        }

    }

    return $answer;

}

public function verificationAuth($token=null, $user_id=0){
    global $app;

    if(!$token || !$user_id){
        return false;
    }

    $get = $app->model->auth->find('token=? and user_id=?', [$token, $user_id]);
    if($get){

        if($get->time_expiration == null || strtotime($get->time_expiration) > $app->datetime->getTime()){

            $data = $app->user->getData($get->user_id);

            if($data && !$data->delete && $data->status == 1){

                return true;

            }

        }

    }

    return false;
}



 }