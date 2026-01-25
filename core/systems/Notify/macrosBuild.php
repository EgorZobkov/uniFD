public function macrosBuild(){
    global $app;

    $macrosList = [];
    $user = [];
    $whomUser = [];

    $macrosList = $this->macrosList();

    if($this->code == "system_new_users"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{user_email}"=>$user->email,
            "{user_phone}"=>$user->phone,
            "{link}"=>getUrlDashboard().'/user/card/'.$this->params["user_id"],
        ]);

    }elseif($this->code == "system_new_transaction"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{transaction_name}"=>$app->component->transaction->getTitleByTemplateAction($this->params),
            "{amount}"=>$app->system->amount($this->params["amount"]),
            "{link}"=>getUrlDashboard().'/user/card/'.$this->params["user_id"],
        ]);

    }elseif($this->code == "system_chat_new_message"){

        $macrosList = array_merge($macrosList, [
            "{message_text}"=>$this->params["text"],
            "{count}"=>$this->params["count"],
            "{link}"=>$app->router->getRoute("profile-chat", [], true),
        ]);

    }elseif($this->code == "system_open_dispute_deal"){

        $macrosList = array_merge($macrosList, [
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$app->router->getRoute("dashboard-deal-card", [$this->params["order_id"]], true),
        ]);


    }elseif($this->code == "system_new_user_verification"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{link}"=>$app->router->getRoute("dashboard-users-verifications", [], true),
        ]);

    }elseif($this->code == "system_open_shop"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);
        $shop = $app->model->shops->find("id=?", [$this->params["shop_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{shop_name}"=>$shop->title,
            "{link}"=>$app->router->getRoute("dashboard-shops", [], true),
        ]);

    }elseif($this->code == "system_edit_shop"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);
        $shop = $app->model->shops->find("id=?", [$this->params["shop_id"]]);

        if($this->params["action"] == "edit_shop"){
            $action_name = translate("tr_5c3e428c63495f87dfb34a72e9840496");
        }elseif($this->params["action"] == "add_banner_shop"){
            $action_name = translate("tr_8509aa5a3a04020d9200d63674a07ba8");
        }elseif($this->params["action"] == "add_page_shop"){
            $action_name = translate("tr_1eb0677007ce6cae423bd525cef970cc");
        }elseif($this->params["action"] == "edit_page_text_shop"){
            $action_name = translate("tr_8e098cf7208e1648bffb33158b92fc78")." ".$this->params["page_name"];
        }

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{shop_name}"=>$shop->title,
            "{page_name}"=>$this->params["page_name"],
            "{action_name}"=>$action_name,
            "{link}"=>$app->router->getRoute("dashboard-shops", [], true),
        ]);

    }elseif($this->code == "system_add_stories"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{link}"=>$app->router->getRoute("dashboard-stories", [], true),
        ]);

    }elseif($this->code == "system_create_ad"){

        $user = $app->model->users->find("id=?", [$this->params["user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{ad_title}"=>$this->params["ad_title"],
            "{ad_category_name}"=>$this->params["ad_category_name"],
            "{link}"=>$app->router->getRoute("dashboard-ads", [], true),
        ]);

    }elseif($this->code == "system_create_review"){

        $ad = $app->model->ads_data->find("id=?", [$this->params["item_id"]]);
        $user = $app->model->users->find("id=?", [$this->params["from_user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($user),
            "{ad_title}"=>$ad->title,
            "{review_text}"=>$this->params["text"],
            "{review_rating}"=>$this->params["rating"],
            "{link}"=>$app->router->getRoute("dashboard-reviews", [], true),
        ]);

    }elseif($this->code == "system_add_complaint_user"){

        $fromUser = $app->model->users->find("id=?", [$this->params["from_user_id"]]);
        $whomUser = $app->model->users->find("id=?", [$this->params["whom_user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{from_user_name}"=>$app->user->name($fromUser),
            "{whom_user_name}"=>$app->user->name($whomUser),
            "{complaint_text}"=>$this->params["text"],
            "{link}"=>$app->router->getRoute("dashboard-complaints", [], true),
        ]);

    }elseif($this->code == "system_add_complaint_ad"){

        $ad = $app->model->ads_data->find("id=?", [$this->params["item_id"]]);
        $fromUser = $app->model->users->find("id=?", [$this->params["from_user_id"]]);
        $whomUser = $app->model->users->find("id=?", [$this->params["whom_user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{from_user_name}"=>$app->user->name($fromUser),
            "{whom_user_name}"=>$app->user->name($whomUser),
            "{complaint_text}"=>$this->params["text"],
            "{ad_title}"=>$ad->title,
            "{link}"=>$app->router->getRoute("dashboard-complaints", [], true),
        ]);

    }elseif($this->code == "board_ad_active"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{ad_title}"=>$this->params["ad_title"],
            "{ad_link}"=>$this->params["ad_link"],
        ]);

    }elseif($this->code == "board_ad_blocked"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{ad_title}"=>$this->params["ad_title"],
            "{ad_link}"=>$this->params["ad_link"],
        ]);

    }elseif($this->code == "user_balance_replenishment"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{text}"=>$this->params["text"],
            "{amount}"=>$app->system->amount($this->params["amount"]),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "user_balance_write_downs"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{text}"=>$this->params["text"],
            "{amount}"=>$app->system->amount($this->params["amount"]),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "chat_new_message"){

        $fromUser = [];

        if($this->params["user_id"]){
            $fromUser = $app->model->users->find("id=?", [$this->params["user_id"]]);
        }

        $macrosList = array_merge($macrosList, [
            "{from_user_name}"=>$fromUser ? $app->user->name($fromUser) : "",
            "{user_name}"=>$app->user->name($this->user),
            "{message_text}"=>$this->params["text"]?:"",
            "{count}"=>$this->params["count"],
            "{link}"=>$app->router->getRoute("profile-chat", [], true),
        ]);

    }elseif($this->code == "deal_error"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "payment_order_deal"){

        $ad = $app->model->ads_data->find("id=?", [$this->params["item_id"]]);
        $fromUser = $app->model->users->find("id=?", [$this->params["from_user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{from_user_name}"=>$app->user->name($fromUser),
            "{user_name}"=>$app->user->name($this->user),
            "{ad_title}"=>$ad->title,
            "{count}"=>$this->params["count"],
            "{amount}"=>$app->system->amount($this->params["amount"]),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "create_order_booking"){

        $ad = $app->model->ads_data->find("id=?", [$this->params["item_id"]]);
        $fromUser = $app->model->users->find("id=?", [$this->params["from_user_id"]]);

        $macrosList = array_merge($macrosList, [
            "{from_user_name}"=>$app->user->name($fromUser),
            "{user_name}"=>$app->user->name($this->user),
            "{contact_user_name}"=>$this->params["user_name"],
            "{contact_user_phone}"=>$this->params["user_phone"],
            "{contact_user_email}"=>$this->params["user_email"],
            "{ad_title}"=>$ad->title,
            "{date_start}"=>$app->datetime->outDate($this->params["date_start"]),
            "{date_end}"=>$app->datetime->outDate($this->params["date_end"]),
            "{amount}"=>$app->system->amount($this->params["amount"]),
            "{count_guests}"=>$this->params["count_guests"],
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "confirmed_order_deal"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "change_status_order_deal"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "open_dispute_order_deal"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "cancel_order_deal"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{order_id}"=>$this->params["order_id"],
            "{link}"=>$this->params["link"],
        ]);

    }elseif($this->code == "board_ad_end_term"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{ad_title}"=>$this->params["ad_title"],
            "{ad_link}"=>$this->params["ad_link"],
        ]);

    }elseif($this->code == "service_tariff_end_term"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "soon_service_tariff_end_term"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "referral_accrued_award"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "user_verification_verified"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "user_verification_rejected"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{text}"=>$this->params["text"],
            "{link}"=>$app->component->profile->linkUserCard($this->user->alias),
        ]);

    }elseif($this->code == "user_shop_published"){

        $shop = $app->model->shops->find("id=?", [$this->params["shop_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{shop_name}"=>$shop->title,
            "{shop_link}"=>$this->params["shop_link"],
        ]);

    }elseif($this->code == "user_shop_rejected"){

        $shop = $app->model->shops->find("id=?", [$this->params["shop_id"]]);

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$app->user->name($this->user),
            "{shop_name}"=>$shop->title,
            "{text}"=>$this->params["text"],
            "{shop_link}"=>$this->params["shop_link"],
        ]);

    }elseif($this->code == "system_auth_reset_password"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$this->params["user_name"],
            "{user_email}"=>$this->params["user_email"],
            "{password}"=>$this->params["password"],
        ]);

    }elseif($this->code == "system_send_access_administrator"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$this->params["user_name"],
            "{user_email}"=>$this->params["user_email"],
            "{login}"=>$this->params["login"],
            "{password}"=>$this->params["password"],
        ]);

    }elseif($this->code == "confirm_email"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$this->params["user_name"],
            "{code}"=>$this->params["code"],
        ]);

    }elseif($this->code == "system_report"){

        $macrosList = array_merge($macrosList, [
            "{user_name}"=>$this->params["user_name"],
            "{user_email}"=>$this->params["user_email"],
            "{link}"=>$this->params["link"],
        ]);

    }

    return $macrosList;
  
}