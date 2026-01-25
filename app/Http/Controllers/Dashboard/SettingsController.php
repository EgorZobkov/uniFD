<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class SettingsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function clearCache()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->caching->flush();

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));
    return json_answer(["status"=>true]);

}

public function compileCore()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $result = $this->builder->compileCore();

    return dd($result);

}

public function integrationsDeliveryLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->delivery($_POST["id"])->fieldsForm()]);

}

public function integrationsDeliverySaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->system_delivery_services->find("id=?", [$_POST["id"]]);

    if($data){

        $this->model->system_delivery_services->update(["status"=>$_POST["status"], "name"=>$_POST["name"], "params"=>encrypt(_json_encode($_POST["params"])), "image"=>$_POST['manager_image'] ?: null, "available_price_min"=>(int)$_POST["available_price_min"], "available_price_max"=>(int)$_POST["available_price_max"], "min_weight"=>(int)$_POST["min_weight"], "max_weight"=>(int)$_POST["max_weight"]], $_POST["id"]);

        $this->addons->delivery($data->alias)->getPoints();

    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}

public function integrationsMessengerLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->messenger($_POST["id"])->fieldsForm()]);

}

public function integrationsMessengerSaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->system_messenger_services->find("id=?", [$_POST["id"]]);

    if($data){

        $this->model->system_messenger_services->update(["name"=>$_POST['name'] ?: null, "params"=>encrypt(_json_encode($_POST["params"])), "image"=>$_POST['manager_image'] ?: null], $_POST["id"]);

        $this->addons->messenger($_POST["id"])->trigger();

    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}

public function integrationsOAuthLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->oauth($_POST["id"])->fieldsForm()]);

}

public function integrationsOAuthSaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->system_oauth_services->find("id=?", [$_POST["id"]]);

    if($data){

        $this->model->system_oauth_services->update(["name"=>$_POST['name'] ?: null, "params"=>encrypt(_json_encode($_POST["params"])), "image"=>$_POST['manager_image'] ?: null], $_POST["id"]);

    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}

public function integrationsPaymentLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->payment($_POST["id"])->fieldsForm()]);

}

public function integrationsPaymentSaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->system_payment_services->update(["status"=>$_POST["status"], "name"=>$_POST["name"], "params"=>encrypt(_json_encode($_POST["params"])), "type_score_name"=>$_POST["type_score_name"], "title"=>$_POST["title"], "secure_deal_min_amount"=>$_POST["secure_deal_min_amount"], "secure_deal_max_amount"=>$_POST["secure_deal_max_amount"], "secure_deal_status"=>(int)$_POST["secure_deal_status"], "image"=>$_POST['manager_image'] ?: null, "secure_description"=>$_POST['secure_description'] ?: null], $_POST["id"]);

    if(!$this->component->settings->getActivePaymentServices()){
        $this->model->settings->update(null,"integration_payment_services_active");
    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}

public function integrationsSmsLoadOptions(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->sms($_POST["id"])->fieldsForm()]);

}

public function integrationsTestSms(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->contact_phone){
        $result = $this->addons->sms($_POST["integration_sms_service"])->test($_POST);
        return json_answer(["status"=>true, "answer"=>_json_encode($result["answer"])]);
    }else{
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"warning", "answer"=>translate("tr_5b9518c48bfd1493d19f21bbc499fa80")]);
    }

}

public function mailingLoadTemplate(){   
    if($_POST["code"]){
        $getTpl = $this->notify->getActionCode($_POST["code"]);
        if(file_exists($this->config->resource->mail->path.'/'.$getTpl->mail_tpl)){
            return json_answer(["content"=>_file_get_contents($this->config->resource->mail->path.'/'.$getTpl->mail_tpl)]);                    
        }
    }
    return json_answer(["content"=>""]);
}

public function mailingTestSend(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->mailer->mailer_service = $_POST['mailer_service'];
    $this->mailer->mailer_from_email = $_POST['mailer_from_email'];
    $this->mailer->mailer_from_name = $_POST['mailer_from_name'];
    $this->mailer->mailer_smtp_host = $_POST['mailer_smtp_host'];
    $this->mailer->mailer_smtp_username = $_POST['mailer_smtp_username'];
    $this->mailer->mailer_smtp_password = $_POST['mailer_smtp_password'];
    $this->mailer->mailer_smtp_port = $_POST['mailer_smtp_port'];
    $this->mailer->mailer_smtp_secure = $_POST['mailer_smtp_secure'];
    $this->mailer->mailer_service_api_key = $_POST['mailer_service_api_key'];

    return $this->mailer->body(['subject'=>translate("tr_5e3d5c58fa308ad3fc40c94d4f9c79d2"),'body'=>translate("tr_5e3d5c58fa308ad3fc40c94d4f9c79d2")])->to($_POST['mailer_from_email'])->send();
}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/settings.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_c919d65bd95698af8f15fa8133bf490d")=>$this->router->getRoute("dashboard-settings")],"route_name"=>"dashboard-settings","page_name"=>translate("tr_c919d65bd95698af8f15fa8133bf490d"),"page_icon"=>"ti-settings","favorite_status"=>true]]);

    return $this->view->preload('settings', ["title"=>translate("tr_c919d65bd95698af8f15fa8133bf490d")]);

}

public function saveAccess(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if(!$_POST["access_status"]){

        if($this->validation->requiredField($_POST['access_action'])->status == false){
            $answer['access_action'] = $this->validation->error;
        }

        if($_POST['access_action'] == "text"){

            if($this->validation->requiredField($_POST['access_text'])->status == false){
                $answer['access_text'] = $this->validation->error;
            }

        }elseif($_POST['access_action'] == "redirect"){
            
            if($this->validation->requiredField($_POST['access_redirect_link'])->status == false){
                $answer['access_redirect_link'] = $this->validation->error;
            }

        }

    }

    if(empty($answer)){

        $this->model->settings->update($_POST["access_status"],"access_status");
        $this->model->settings->update($_POST["access_action"],"access_action");
        $this->model->settings->update($_POST["access_text"],"access_text");
        $this->model->settings->update($_POST["access_redirect_link"],"access_redirect_link");
        $this->model->settings->update($_POST["access_allowed_ip"],"access_allowed_ip");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

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

public function saveGraphics()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST["watermark_title_opacity"] = intval($_POST["watermark_title_opacity"]) < 0 || intval($_POST["watermark_title_opacity"]) > 100 ? 80 : intval($_POST["watermark_title_opacity"]);
    $_POST["watermark_title"] = trimStr($_POST["watermark_title"], 50);

    if($_POST["watermark_image_percent_size"] > 100){
        $_POST["watermark_image_percent_size"] = 100;
    }

    if($_POST["watermark_image_opacity"] > 100){
        $_POST["watermark_image_opacity"] = 100;
    }

    if($_POST["watermark_type"] == "title"){
        if($this->validation->requiredField($_POST['watermark_title'])->status == false){
            $answer['watermark_title'] = $this->validation->error;
        }
    }elseif($_POST["watermark_type"] == "image"){
        if($this->validation->requiredField($_POST['watermark_image'])->status == false){
            $answer['watermark_image'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->settings->update($_POST['logo_main']?:null,"logo_main");
        $this->model->settings->update($_POST['logo_emblem']?:null,"logo_emblem");
        $this->model->settings->update($_POST['favicon']?:null,"favicon");

        $this->model->settings->update($_POST["watermark_status"],"watermark_status");
        $this->model->settings->update($_POST["watermark_type"],"watermark_type");
        $this->model->settings->update($_POST["watermark_title"],"watermark_title");
        $this->model->settings->update($_POST["watermark_title_font"],"watermark_title_font");
        $this->model->settings->update($_POST["watermark_title_size"],"watermark_title_size");
        $this->model->settings->update($_POST["watermark_title_opacity"],"watermark_title_opacity");
        $this->model->settings->update($_POST["watermark_image_position"],"watermark_image_position");
        $this->model->settings->update(abs($_POST["watermark_image_percent_size"]),"watermark_image_percent_size");
        $this->model->settings->update(abs($_POST["watermark_image_opacity"]),"watermark_image_opacity");
        $this->model->settings->update($_POST['watermark_image']?:null,"watermark_image");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function saveHome()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST["out_default_count_items_home"] > 1000){
        $_POST["out_default_count_items_home"] = 1000;
    }

    if($_POST["frontend_home_visible_widgets"]){
        $key = 1;
        foreach ($_POST["frontend_home_visible_widgets"] as $code => $value) {
            $this->model->frontend_home_widgets->update(["sorting"=>$key, "status"=>$_POST["frontend_home_visible_widgets_active"][$code] ? 1 : 0], ["code=?", [$code]]);
            $key++;
        }
    }

    $this->model->settings->update(_json_encode($_POST["frontend_home_slider_categories_ids"]),"frontend_home_slider_categories_ids");
    $this->model->settings->update($_POST["out_default_count_items_home"],"out_default_count_items_home");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}

public function saveInformation()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['project_name'])->status == false){
        $answer['project_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['project_title'])->status == false){
        $answer['project_title'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["project_name"],"project_name");
        $this->model->settings->update($_POST["project_title"],"project_title");
        $this->model->settings->update($_POST["contact_email"],"contact_email");
        $this->model->settings->update($_POST["contact_phone"],"contact_phone");
        $this->model->settings->update($_POST["contact_organization_name"],"contact_organization_name");
        $this->model->settings->update($_POST["contact_organization_address"],"contact_organization_address");
        $this->model->settings->update(_json_encode($_POST["contact_social_links"]),"contact_social_links");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function saveIntegrations(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($_POST["integration_map_service"]){
        if($this->validation->requiredField($_POST['integration_map_key'])->status == false){
            $answer["integration_map_key"] = $this->validation->error;
        }            
    }else{
        $_POST['integration_map_key'] = "";
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["integration_messenger_service"]?:null,"integration_messenger_service");
        $this->model->settings->update($_POST["integration_map_service"]?:null,"integration_map_service");
        $this->model->settings->update($_POST["integration_map_key"]?:null,"integration_map_key");
        $this->model->settings->update($_POST["integration_map_lang"]?:null,"integration_map_lang");
        $this->model->settings->update($_POST["integration_sms_service"] ?: null,"integration_sms_service");
        $this->model->settings->update($_POST["integration_sms_service_data"] ? encrypt(_json_encode($_POST["integration_sms_service_data"])) : null,"integration_sms_service_data");
        $this->model->settings->update($_POST["integration_payment_services_active"] ? _json_encode($_POST["integration_payment_services_active"]) : null,"integration_payment_services_active");
        $this->model->settings->update($_POST["integration_payment_service_secure_deal_active"],"integration_payment_service_secure_deal_active");
        $this->model->settings->update($_POST["integration_delivery_services_active"] ? _json_encode($_POST["integration_delivery_services_active"]) : null,"integration_delivery_services_active");

        $this->model->settings->update($_POST["auth_services_list"] ? _json_encode($_POST["auth_services_list"]) : null,"auth_services_list");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function saveMailing()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['mailer_from_name'])->status == false){
        $answer['mailer_from_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['mailer_from_email'])->status == false){
        $answer['mailer_from_email'] = $this->validation->error;
    }

    if($_POST["mailer_service"] == "smtp"){
        if($this->validation->requiredField($_POST['mailer_smtp_host'])->status == false){
            $answer['mailer_smtp_host'] = $this->validation->error;
        }   
        if($this->validation->requiredField($_POST['mailer_smtp_port'])->status == false){
            $answer['mailer_smtp_port'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_username'])->status == false){
            $answer['mailer_smtp_username'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_password'])->status == false){
            $answer['mailer_smtp_password'] = $this->validation->error;
        }
        if($this->validation->requiredField($_POST['mailer_smtp_secure'])->status == false){
            $answer['mailer_smtp_secure'] = $this->validation->error;
        }         
    }

    if(!$_POST["mailer_service"] || $_POST["mailer_service"] == "smtp"){
        $_POST["mailer_service_api_key"] = "";
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["mailer_service"],"mailer_service");
        $this->model->settings->update($_POST["mailer_service_api_key"] ? encrypt($_POST["mailer_service_api_key"]) : "","mailer_service_api_key");
        $this->model->settings->update($_POST["mailer_smtp_host"],"mailer_smtp_host");
        $this->model->settings->update($_POST["mailer_smtp_port"],"mailer_smtp_port");
        $this->model->settings->update($_POST["mailer_smtp_username"],"mailer_smtp_username");
        $this->model->settings->update($_POST["mailer_smtp_password"],"mailer_smtp_password");
        $this->model->settings->update($_POST["mailer_smtp_secure"],"mailer_smtp_secure");
        $this->model->settings->update($_POST["mailer_from_email"],"mailer_from_email");
        $this->model->settings->update($_POST["mailer_from_name"],"mailer_from_name");

        if($_POST["mailer_template_code"]){
            $getTpl = $this->notify->getActionCode($_POST["mailer_template_code"]);
            _file_put_contents($this->config->resource->mail->path.'/'.$getTpl->mail_tpl, urldecode($_POST["mailer_template_body"]));
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

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

public function saveProfile()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if(!$_POST["stories_max_duration_image"]){
        $_POST["stories_max_duration_image"] = 10;
    }

    if(!$_POST["stories_max_duration_video"]){
        $_POST["stories_max_duration_video"] = 10;
    }

    if(!$_POST["stories_max_size_image"]){
        $_POST["stories_max_size_image"] = 20;
    }

    if(!$_POST["stories_max_size_video"]){
        $_POST["stories_max_size_video"] = 50;
    }

    if($_POST["referral_program_percent_award"] > 100){
        $_POST["referral_program_percent_award"] = 100;
    }

    $this->model->settings->update($_POST["registration_authorization_method"],"registration_authorization_method");
    $this->model->settings->update($_POST["registration_authorization_view"],"registration_authorization_view");
    $this->model->settings->update($_POST["verification_users_status"],"verification_users_status");
    $this->model->settings->update($_POST["verification_users_permissions"] ? _json_encode($_POST["verification_users_permissions"]) : null,"verification_users_permissions");
    $this->model->settings->update($_POST["profile_wallet_status"],"profile_wallet_status");
    $this->model->settings->update($_POST["profile_wallet_min_amount_replenishment"],"profile_wallet_min_amount_replenishment");
    $this->model->settings->update($_POST["profile_wallet_max_amount_replenishment"],"profile_wallet_max_amount_replenishment");

    $this->model->settings->update($_POST["shop_moderation_status"],"shop_moderation_status");
    $this->model->settings->update($_POST["shop_max_banners"],"shop_max_banners");
    $this->model->settings->update($_POST["shop_max_pages"],"shop_max_pages");
    
    $this->model->settings->update($_POST["stories_moderation_status"],"stories_moderation_status");
    $this->model->settings->update($_POST["stories_period_placement"],"stories_period_placement");
    $this->model->settings->update($_POST["stories_max_size_image"],"stories_max_size_image");
    $this->model->settings->update($_POST["stories_max_size_video"],"stories_max_size_video");
    $this->model->settings->update($_POST["stories_max_duration_image"],"stories_max_duration_image");
    $this->model->settings->update($_POST["stories_max_duration_video"],"stories_max_duration_video");

    $this->model->settings->update($_POST["registration_bonus_status"],"registration_bonus_status");
    $this->model->settings->update($_POST["registration_bonus_amount"],"registration_bonus_amount");

    $this->model->settings->update($_POST["referral_program_status"],"referral_program_status");
    $this->model->settings->update(abs($_POST["referral_program_percent_award"]),"referral_program_percent_award");

    $this->model->settings->update(abs($_POST["profile_notifications_messenger_status"]),"profile_notifications_messenger_status");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}

public function saveSeo()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content_robots = '';

    $content_robots = "User-agent: *\n";

    if(!$_POST["seo_robots_index_status"]){
       $content_robots .= "Disallow: /\n";
    }
   
    $content_robots .= "Host: " . getHost() . "\n";
    $content_robots .= "Sitemap: " . getHost() . "/sitemap.xml\n";

    $content_robots .= "Disallow: /?*\n";

    file_put_contents(BASE_PATH . "/robots.txt", $_POST["seo_robots_manual"] ? $_POST["seo_robots_data"] : $content_robots);

    $this->model->settings->update(_json_encode($_POST["seo_sitemap_output"]),"seo_sitemap_output");
    $this->model->settings->update($_POST["seo_robots_index_status"],"seo_robots_index_status");
    $this->model->settings->update($_POST["seo_robots_manual"],"seo_robots_manual");
    $this->model->settings->update($_POST["seo_robots_manual"] ? $_POST["seo_robots_data"] : $content_robots,"seo_robots_data");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}

public function saveSystems(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if(!intval($_POST["confirmation_length_code"]) || intval($_POST["confirmation_length_code"]) > 100){
        $_POST["confirmation_length_code"] = 4;
    }

    if(!intval($_POST["system_captcha_attempts_count"])){
        $_POST["system_captcha_attempts_count"] = 2;
    }

    if(!intval($_POST["system_verify_attempts_count"])){
        $_POST["system_verify_attempts_count"] = 2;
    }

    if(!intval($_POST["system_verify_block_time"])){
        $_POST["system_verify_block_time"] = 90;
    }

    if($_POST["default_language"] != $this->settings->default_language){
        $this->component->translate->setMainIso($_POST["default_language"]);
    }

    $this->model->settings->update($_POST["default_language"],"default_language");
    $this->model->settings->update($_POST["system_timezone"],"system_timezone");
    $this->model->settings->update($_POST["system_default_currency"],"system_default_currency");
    $this->model->settings->update($_POST["system_extra_currency"] ? _json_encode($_POST["system_extra_currency"]) : null,"system_extra_currency");
    $this->model->settings->update($_POST["system_currency_position"],"system_currency_position");
    $this->model->settings->update($_POST["system_currency_spacing"],"system_currency_spacing");
    $this->model->settings->update($_POST["system_price_reduction_status"],"system_price_reduction_status");
    $this->model->settings->update($_POST["system_price_separator"],"system_price_separator");
    $this->model->settings->update($_POST["frontend_scripts"],"frontend_scripts");
    $this->model->settings->update($_POST["system_report_status"],"system_report_status");
    $this->model->settings->update($_POST["system_report_period"],"system_report_period");
    $this->model->settings->update($_POST["system_report_recipients_ids"] ? _json_encode($_POST["system_report_recipients_ids"]) : null,"system_report_recipients_ids");
    $this->model->settings->update($_POST["system_report_send_time"] ?: "23:59","system_report_send_time");
    $this->model->settings->update($_POST["system_report_send_if_zero"],"system_report_send_if_zero");
    $this->model->settings->update($_POST["geo_autodetect"],"geo_autodetect");
    $this->model->settings->update($_POST["system_captcha_status"],"system_captcha_status");
    $this->model->settings->update($_POST["confirmation_length_code"],"confirmation_length_code");
    $this->model->settings->update($_POST["multi_languages_status"],"multi_languages_status");
    $this->model->settings->update($_POST["phone_confirmation_status"],"phone_confirmation_status");
    $this->model->settings->update($_POST["phone_confirmation_service"],"phone_confirmation_service");
    $this->model->settings->update($_POST["email_confirmation_status"],"email_confirmation_status");
    $this->model->settings->update($_POST["allowed_templates_email_all_status"],"allowed_templates_email_all_status");
    $this->model->settings->update($_POST["allowed_templates_email"],"allowed_templates_email");
    $this->model->settings->update($_POST["allowed_templates_phone_all_status"],"allowed_templates_phone_all_status");
    $this->model->settings->update($_POST["allowed_templates_phone"] ? _json_encode($_POST["allowed_templates_phone"]) : null,"allowed_templates_phone");

    $this->model->settings->update(intval($_POST["system_captcha_attempts_count"]),"system_captcha_attempts_count");
    $this->model->settings->update(intval($_POST["system_verify_attempts_count"]),"system_verify_attempts_count");
    $this->model->settings->update(intval($_POST["system_verify_block_time"]),"system_verify_block_time");
    $this->model->settings->update($_POST["default_template_phone_iso"] ?: null,"default_template_phone_iso");

    if($_POST["system_measurement"]){
        $current_ids = [];
        if(is_array($_POST["system_measurement"])){
            foreach ($_POST["system_measurement"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                    if($action == "add"){
                        if(trim($value)){
                            $current_ids[] = $this->model->system_measurements->insert(["name"=>$value]);
                        }
                    }
                    if($action == "update"){
                        if(trim($value)){
                            $this->model->system_measurements->update(["name"=>$value], $id);
                            $current_ids[] = $id;
                        }
                    }
                }  
            }
            if($current_ids){
                $this->model->system_measurements->delete("id NOT IN(".implode(",", $current_ids).")");
            }
        }
    }else{
        $this->model->system_measurements->delete();
    }

    if($_POST["system_price_names"]){
        $current_ids = [];
        if(is_array($_POST["system_price_names"])){
            foreach ($_POST["system_price_names"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                    if($action == "add"){
                        if(trim($value)){
                            $current_ids[] = $this->model->system_price_names->insert(["name"=>$value]);
                        }
                    }
                    if($action == "update"){
                        if(trim($value)){
                            $this->model->system_price_names->update(["name"=>$value], $id);
                            $current_ids[] = $id;
                        }
                    }
                }  
            }
            if($current_ids){
                $this->model->system_price_names->delete("id NOT IN(".implode(",", $current_ids).")");
            }
        }
    }else{
        $this->model->system_price_names->delete();
    }

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}



 }