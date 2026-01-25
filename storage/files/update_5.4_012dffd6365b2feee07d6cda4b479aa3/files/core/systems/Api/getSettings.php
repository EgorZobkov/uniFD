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