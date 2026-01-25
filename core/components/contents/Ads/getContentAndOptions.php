public function getContentAndOptions($data=[], $ad=[]){
     global $app;

     $data["price_currency_status"] = false;
     $data["term_date_status"] = false;
     $data["price_fixed_change_status"] = false;
     $data["price_gratis_status"] = false;
     $data["price_measurement_status"] = false;

     $data["filters"] = $app->component->ads_filters->outFiltersInAdCreate($data['category_id'], $ad ? $ad->id : 0);

     if($app->component->ads_categories->categories[$data['category_id']]["price_status"]){

        $priceName = $app->model->system_price_names->find("id=?", [$app->component->ads_categories->categories[$data['category_id']]["price_name_id"]]);

        if($priceName){
            $data["price_name"] = translateField($priceName->name);
        }else{
            $data["price_name"] = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }

        if($app->component->ads_categories->categories[$data['category_id']]["price_measure_ids"]){
            $measurements = $app->model->system_measurements->getAll("id IN(".implode(",", _json_decode($app->component->ads_categories->categories[$data['category_id']]["price_measure_ids"])).")");
            if($measurements){
                foreach ($measurements as $measurement) {
                    $measurementsBuildUniSelectItems[] = ["item_name"=>translateField($measurement["name"]),"input_name"=>"price_measurement","input_value"=>$measurement["id"]];
                }
                $data["price_measurement_status"] = true;
                $data["price_measurement_items"] = $app->ui->buildUniSelect($measurementsBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->price_measure_id : 0 ]]);
                $data["price_measurement_items_array"] = $measurements;
            }
        }

        if($app->component->ads_categories->categories[$data['category_id']]["price_fixed_change"]){
            $data["price_fixed_change_status"] = true;
        }

        if($app->component->ads_categories->categories[$data['category_id']]["gratis_status"] && !$app->component->ads_categories->categories[$data['category_id']]["price_required"]){
            $data["price_gratis_status"] = true;
        }

        if($app->settings->board_publication_currency_status && $app->settings->system_extra_currency){

            if($app->settings->system_extra_currency){

                foreach ($app->settings->system_extra_currency as $code) {
                    $currencyBuildUniSelectItems[] = ["item_name"=>$app->system->getCurrencyByCode($code)->symbol,"input_name"=>"price_currency_code","input_value"=>$app->system->getCurrencyByCode($code)->code];
                }

                $data["price_currency_items"] = $app->ui->buildUniSelect($currencyBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->currency_code : $app->system->getDefaultCurrency()->code ]]);
                $data["price_currency_status"] = true;

            }

        }

    }

    if($app->settings->board_publication_term_date_status){

        if($app->settings->board_publication_term_date_list){

            foreach (explode(",", $app->settings->board_publication_term_date_list) as $day) {
                $termDateBuildUniSelectItems[] = ["item_name"=>$day.' '.endingWord($day, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),"input_name"=>"term_date_day","input_value"=>$day];
            }

            $data["term_date_items"] = $app->ui->buildUniSelect($termDateBuildUniSelectItems, ["view"=>"radio", "selected"=>[ $ad ? $ad->publication_period : $app->settings->board_publication_term_date_default ]]);
            $data["term_date_status"] = true;

        }

    }

    if($app->component->ads_categories->categories[$data['category_id']]["booking_status"]){
        return $app->view->setParamsComponent(['data'=>(object)$data, "ad"=>$ad ? (object)$ad : []])->includeComponent('ad-create-edit-booking-content.tpl');
    }else{
        return $app->view->setParamsComponent(['data'=>(object)$data, "ad"=>$ad ? (object)$ad : []])->includeComponent('ad-create-edit-content.tpl');
    }
    
}