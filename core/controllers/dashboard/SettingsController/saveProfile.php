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