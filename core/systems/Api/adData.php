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