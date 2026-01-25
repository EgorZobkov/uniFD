public function saveMarket()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if(!abs($_POST["board_publication_term_date_default"])){
        $_POST["board_publication_term_date_default"] = 30;
    }

    if(!abs($_POST["board_publication_max_length_title"])){
        $_POST["board_publication_max_length_title"] = 70;
    }

    if(!abs($_POST["board_publication_max_length_text"])){
        $_POST["board_publication_max_length_text"] = 3000;
    }

    if(!abs($_POST["board_publication_max_size_image"])){
        $_POST["board_publication_max_size_image"] = 25;
    }

    if(!abs($_POST["board_publication_max_size_video"])){
        $_POST["board_publication_max_size_video"] = 25;
    }

    if(!abs($_POST["board_publication_limit_count_media"])){
        $_POST["board_publication_limit_count_media"] = 10;
    }

    if(abs($_POST["secure_deal_profit_percent"]) > 99){
        $_POST["secure_deal_profit_percent"] = 99;
    }

    if(abs($_POST["secure_deal_auto_closing_time"]) == 0){
        $_POST["secure_deal_auto_closing_time"] = 1;
    }

    if(!abs($_POST["board_catalog_height_item"])){
        $_POST["board_catalog_height_item"] = 224;
    }

    if($_POST["out_default_count_items"] > 1000){
        $_POST["out_default_count_items"] = 1000;
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["basket_status"],"basket_status");
        $this->model->settings->update($_POST["shops_status"],"shops_status");
        $this->model->settings->update($_POST["paid_services_status"],"paid_services_status");
        $this->model->settings->update($_POST["board_cost_publication"],"board_cost_publication");
        $this->model->settings->update($_POST["board_cost_publication_type"],"board_cost_publication_type");
        $this->model->settings->update($_POST["board_publication_moderation_status"],"board_publication_moderation_status");
        $this->model->settings->update($_POST["board_publication_smart_moderation_status"],"board_publication_smart_moderation_status");
        $this->model->settings->update($_POST["board_publication_premoderation_status"],"board_publication_premoderation_status");
        $this->model->settings->update($_POST["board_publication_premoderation_conditions"] ? _json_encode($_POST["board_publication_premoderation_conditions"]) : null,"board_publication_premoderation_conditions");
        $this->model->settings->update($_POST["board_publication_forbidden_words"],"board_publication_forbidden_words");
        $this->model->settings->update($_POST["board_publication_required_phone_number"],"board_publication_required_phone_number");
        $this->model->settings->update($_POST["board_publication_required_email"],"board_publication_required_email");
        $this->model->settings->update($_POST["board_publication_required_contact_whatsapp"],"board_publication_required_contact_whatsapp");
        $this->model->settings->update($_POST["board_publication_required_contact_telegram"],"board_publication_required_contact_telegram");
        $this->model->settings->update($_POST["board_publication_required_contact_max"],"board_publication_required_contact_max");
        $this->model->settings->update($_POST["board_publication_currency_status"],"board_publication_currency_status");
        $this->model->settings->update($_POST["board_publication_term_date_status"],"board_publication_term_date_status");
        $this->model->settings->update($_POST["board_publication_term_date_default"],"board_publication_term_date_default");
        $this->model->settings->update($_POST["board_publication_only_photos"],"board_publication_only_photos");
        $this->model->settings->update($_POST["board_publication_limit_count_media"],"board_publication_limit_count_media");
        $this->model->settings->update($_POST["board_publication_min_length_title"],"board_publication_min_length_title");
        $this->model->settings->update($_POST["board_publication_max_length_title"],"board_publication_max_length_title");
        $this->model->settings->update($_POST["board_publication_min_length_text"],"board_publication_min_length_text");
        $this->model->settings->update($_POST["board_publication_max_length_text"],"board_publication_max_length_text");
        $this->model->settings->update($_POST["board_publication_max_size_image"],"board_publication_max_size_image");
        $this->model->settings->update($_POST["board_publication_max_size_video"],"board_publication_max_size_video");
        $this->model->settings->update($_POST["board_publication_add_video_status"],"board_publication_add_video_status");
        $this->model->settings->update($_POST["board_card_price_different_currencies"],"board_card_price_different_currencies");
        $this->model->settings->update($_POST["board_card_who_phone_view"],"board_card_who_phone_view");
        $this->model->settings->update($_POST["board_catalog_ad_view"],"board_catalog_ad_view");
        $this->model->settings->update($_POST["board_catalog_ad_option_opening"],"board_catalog_ad_option_opening");
        $this->model->settings->update(abs($_POST["secure_deal_profit_percent"]),"secure_deal_profit_percent");
        $this->model->settings->update(abs($_POST["secure_deal_auto_closing_time"]),"secure_deal_auto_closing_time");
        $this->model->settings->update($_POST["board_catalog_height_item"],"board_catalog_height_item");
        $this->model->settings->update($_POST["board_card_who_transition_partner_link"],"board_card_who_transition_partner_link");
        $this->model->settings->update($_POST["out_default_count_items"],"out_default_count_items");
        $this->model->settings->update($_POST["board_ads_geo_distance"],"board_ads_geo_distance");
        $this->model->settings->update($_POST["out_default_count_city_distance_items"],"out_default_count_city_distance_items");
        $this->model->settings->update($_POST["search_allowed_tables"] ? _json_encode($_POST["search_allowed_tables"]) : null,"search_allowed_tables");
        $this->model->settings->update($_POST["search_stopwords"],"search_stopwords");
        $this->model->settings->update(intval($_POST["search_allowed_text"]),"search_allowed_text");
        $this->model->settings->update(intval($_POST["board_publication_partner_products_active_tariffs"]),"board_publication_partner_products_active_tariffs");
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}