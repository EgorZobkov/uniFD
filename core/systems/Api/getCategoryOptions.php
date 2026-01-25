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