public function saveApiApp(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $start_promo_banners = [];
    $main_page_slider_banners = [];
    $main_page_out_content = [];
    $main_page_promo_sections = [];

    if($_POST["api_app_start_promo_banners"]){
        foreach ($_POST["api_app_start_promo_banners"] as $key => $value) {
            if($value["title"]){
                $start_promo_banners[$key] = ["title"=>$value["title"]?:null, "image_link"=>$value["image_link"]?:null, "color_bg"=>$value["color_bg"]?:null, "color_text"=>$value["color_text"]?:null, "text"=>$value["text"]?:null];
            }
        }
    }

    if($_POST["api_app_main_page_slider_banners"]){
        foreach ($_POST["api_app_main_page_slider_banners"] as $key => $value) {
            if($value["image_link"]){
                $main_page_slider_banners[$key] = ["target"=>$value["target"]?:null, "image_link"=>$value["image_link"]?:null];
            }
        }
    }

    if($_POST["api_app_main_page_out_content_all"]){
        foreach ($_POST["api_app_main_page_out_content_all"] as $key => $value) {
            $main_page_out_content[][$value] = $_POST["api_app_main_page_out_content"][$value] ? true : null;
        }
    }

    if($_POST["api_app_main_page_promo_sections"]){
        foreach ($_POST["api_app_main_page_promo_sections"] as $key => $value) {
            if(strpos($value["target"], "http") === false){
                $split = explode(":", $value["target"]);
                if($split[1] == "category"){
                    $category = $this->component->ads_categories->categories[(int)$split[2]];
                    if($category){
                        $chain_array = $this->component->ads_categories->getParentsId($category["id"]);
                        $breadcrumb = $this->component->ads_categories->getBuildNameChain($chain_array);
                        $main_page_promo_sections[$key] = ["name"=>$value["name"], "target"=>$value["target"], "image_link"=>$value["image_link"], "category"=>["name"=>$category["name"], "id"=>$category["id"], "breadcrumb"=>$breadcrumb]];
                    }
                }else{
                    $main_page_promo_sections[$key] = ["name"=>$value["name"], "target"=>$value["target"], "image_link"=>$value["image_link"]];
                }
            }else{
                $main_page_promo_sections[$key] = ["name"=>$value["name"], "target"=>$value["target"], "image_link"=>$value["image_link"]];
            }
        }
    }

    $this->model->settings->update($_POST["api_app_project_name"],"api_app_project_name");
    $this->model->settings->update($_POST["api_app_user_agreement_link"],"api_app_user_agreement_link");
    $this->model->settings->update($_POST["api_app_privacy_policy_link"],"api_app_privacy_policy_link");
    $this->model->settings->update(intval($_POST["api_app_section_download_status"]),"api_app_section_download_status");
    $this->model->settings->update(intval($_POST["api_app_download_only_apk"]),"api_app_download_only_apk");
    $this->model->settings->update($_POST["api_app_download_link_apk"],"api_app_download_link_apk");
    $this->model->settings->update(_json_encode($_POST["api_app_download_links"]),"api_app_download_links");
    $this->model->settings->update($_POST["api_app_firebase_push_params"] ? encrypt(urldecode($_POST["api_app_firebase_push_params"])) : null,"api_app_firebase_push_params");
    $this->model->settings->update($_POST["api_app_metrica_key"],"api_app_metrica_key");
    $this->model->settings->update(_json_encode($main_page_out_content),"api_app_main_page_out_content");
    $this->model->settings->update(_json_encode($_POST["api_app_main_page_tabs"]),"api_app_main_page_tabs");
    $this->model->settings->update(intval($_POST["api_app_main_page_slider_banners_status"]),"api_app_main_page_slider_banners_status");
    $this->model->settings->update(_json_encode($main_page_slider_banners),"api_app_main_page_slider_banners");
    $this->model->settings->update(_json_encode($start_promo_banners),"api_app_start_promo_banners");
    $this->model->settings->update(intval($_POST["api_app_start_promo_banners_status"]),"api_app_start_promo_banners_status");
    $this->model->settings->update(intval($_POST["api_app_main_page_header_banner_status"]),"api_app_main_page_header_banner_status");
    $this->model->settings->update(_json_encode($_POST["api_app_main_page_header_banner"]),"api_app_main_page_header_banner");
    $this->model->settings->update(_json_encode($_POST["api_app_main_page_registration_box"]),"api_app_main_page_registration_box");
    $this->model->settings->update(intval($_POST["api_app_main_page_promo_sections_status"]),"api_app_main_page_promo_sections_status");
    $this->model->settings->update(_json_encode($main_page_promo_sections),"api_app_main_page_promo_sections");
    $this->model->settings->update($_POST["api_app_main_page_promo_sections_view"],"api_app_main_page_promo_sections_view");
    $this->model->settings->update(_json_encode($_POST["api_app_services_pages"]),"api_app_services_pages");
    $this->model->settings->update($_POST["api_app_catalog_item_card"] ? _json_encode($_POST["api_app_catalog_item_card"]) : null,"api_app_catalog_item_card");
    $this->model->settings->update(intval($_POST["api_app_nav_bar_label_status"]),"api_app_nav_bar_label_status");
    $this->model->settings->update(preg_replace('/\s+/', '', $_POST["api_app_fortune_bonus_items"]),"api_app_fortune_bonus_items");
    $this->model->settings->update(intval($_POST["api_app_fortune_bonus_status"]),"api_app_fortune_bonus_status");
    $this->model->settings->update($_POST["api_app_replenishment_balance_amount_list"] ? preg_replace('/\s+/', '', $_POST["api_app_replenishment_balance_amount_list"]) : null,"api_app_replenishment_balance_amount_list");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}