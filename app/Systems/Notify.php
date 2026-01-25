<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class Notify
 {

 public $data = [];
 public $user = [];
 
 public function actionsCode(){   
    global $app;

    $result["system_auth_reset_password"] = ["code"=>"system_auth_reset_password", "name"=>translate("tr_f490b86156968b0c43cbf28feefacd33"), "mail_tpl"=>"system-auth-reset-password.tpl"];
    $result["system_send_access_administrator"] = ["code"=>"system_send_access_administrator", "name"=>translate("tr_d3946ee416566f74f1fc1861072e1a62"), "mail_tpl"=>"system-send-access-administrator.tpl"];
    $result["board_ad_active"] = ["code"=>"board_ad_active", "name"=>translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " {ad_title} " . translate("tr_6ed440dba05f9f8c24bc230ed42943b0"), "mail_tpl"=>"board-ad-active.tpl"];
    $result["board_ad_blocked"] = ["code"=>"board_ad_blocked", "name"=>translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " {ad_title} " . translate("tr_91dddad62ab1e6186332fc8c5ea7742a"), "mail_tpl"=>"board-ad-blocked.tpl"];
    $result["user_balance_replenishment"] = ["code"=>"user_balance_replenishment", "name"=>translate("tr_4794c3c39a4578aa6096bf3ced5d5a89"), "mail_tpl"=>"user-balance-replenishment.tpl"];
    $result["user_balance_write_downs"] = ["code"=>"user_balance_write_downs", "name"=>translate("tr_174f77c419886a40e05eb447611b8dac"), "mail_tpl"=>"user-balance-write-downs.tpl"];
    $result["confirm_email"] = ["code"=>"confirm_email", "name"=>translate("tr_b39de0757772b9f97c7b2426876c81fc"), "mail_tpl"=>"confirm-email.tpl"];
    $result["chat_new_message"] = ["code"=>"chat_new_message", "name"=>translate("tr_be24e8cfc1630bcb06c2d5f9621cf29a"), "mail_tpl"=>"chat-new-message.tpl"];
    $result["deal_error"] = ["code"=>"deal_error", "name"=>translate("tr_7297fa40298a5768c751620c5c893f16"), "mail_tpl"=>"deal-error.tpl"];
    $result["payment_order_deal"] = ["code"=>"payment_order_deal", "name"=>translate("tr_157298fd7045a53d1be4ea9dfe3d91dc"), "mail_tpl"=>"payment-order-deal.tpl"];
    $result["create_order_booking"] = ["code"=>"create_order_booking", "name"=>translate("tr_a7fa474b588bfde951f40e1e7a3b02b6"), "mail_tpl"=>"create-order-booking.tpl"];
    $result["confirmed_order_deal"] = ["code"=>"confirmed_order_deal", "name"=>translate("tr_d36781aed4035078178702a46f45ce01") . " №{order_id} " . translate("tr_10d0c0e0a17a9582e28418bd74f59ccb"), "mail_tpl"=>"confirmed-order-deal.tpl"];
    $result["change_status_order_deal"] = ["code"=>"change_status_order_deal", "name"=>translate("tr_cd18ce752c6258a5d8573d6ff22f369b") . " №{order_id}", "mail_tpl"=>"change-status-order-deal.tpl"];
    $result["open_dispute_order_deal"] = ["code"=>"open_dispute_order_deal", "name"=>translate("tr_60d5e5561a5085191b4d91cadd6c6000") . "№{order_id}", "mail_tpl"=>"open-dispute-order-deal.tpl"];
    $result["cancel_order_deal"] = ["code"=>"cancel_order_deal", "name"=>translate("tr_d36781aed4035078178702a46f45ce01") . " №{order_id} " . translate("tr_71dd64eab0b03532e8de9d7b301ecf9f"), "mail_tpl"=>"cancel-order-deal.tpl"];
    $result["board_ad_end_term"] = ["code"=>"board_ad_end_term", "name"=>translate("tr_944a5f10b09687118a3a04cabaebec32") . " {ad_title}", "mail_tpl"=>"board-ad-end-term.tpl"];
    $result["service_tariff_end_term"] = ["code"=>"service_tariff_end_term", "name"=>translate("tr_974c912d828402905252c0e2b001d78b"), "mail_tpl"=>"service-tariff-end-term.tpl"];
    $result["soon_service_tariff_end_term"] = ["code"=>"soon_service_tariff_end_term", "name"=>translate("tr_2fafd7e9de985cb05bbea2a35e5c901e"), "mail_tpl"=>"soon-service-tariff-end-term.tpl"];
    $result["referral_accrued_award"] = ["code"=>"referral_accrued_award", "name"=>translate("tr_163170ea0f7f658fec8c496e46c256ba"), "mail_tpl"=>"referral-accrued-award.tpl"];
    $result["user_verification_verified"] = ["code"=>"user_verification_verified", "name"=>translate("tr_59d2252669695fdfdfbe1639053a9463"), "mail_tpl"=>"user-verification-verified.tpl"];
    $result["user_verification_rejected"] = ["code"=>"user_verification_rejected", "name"=>translate("tr_4c10793779f9b1192500e6675ecefa44"), "mail_tpl"=>"user-verification-rejected.tpl"];
    $result["user_shop_published"] = ["code"=>"user_shop_published", "name"=>translate("tr_77d49a9f100e9f21a8d7d6974948c430"), "mail_tpl"=>"user-shop-published.tpl"];
    $result["user_shop_rejected"] = ["code"=>"user_shop_rejected", "name"=>translate("tr_fca49693e7d9e96e8f0e8961cdbe11f9"), "mail_tpl"=>"user-shop-rejected.tpl"];

    $result["system_report"] = ["code"=>"system_report", "name"=>translate("tr_f7e7bb3adb7bd115d9b21d37f1dfb468"), "mail_tpl"=>"system-report.tpl"];
    $result["system_new_users"] = ["code"=>"system_new_users", "name"=>translate("tr_2fbd8719f2595bbe4fc24646e945e9a5"), "mail_tpl"=>"system-new-users.tpl"];
    $result["system_new_transaction"] = ["code"=>"system_new_transaction", "name"=>translate("tr_45f8547c14a487ecbd3f6e190adc2e9e"), "mail_tpl"=>"system-new-transaction.tpl"];
    $result["system_chat_new_message"] = ["code"=>"system_chat_new_message", "name"=>translate("tr_be24e8cfc1630bcb06c2d5f9621cf29a"), "mail_tpl"=>"system-chat-new-message.tpl"];
    $result["system_open_dispute_deal"] = ["code"=>"system_open_dispute_deal", "name"=>translate("tr_e1fc430809c38206dce521425fcf125f"), "mail_tpl"=>"system-open-dispute-deal.tpl"];
    $result["system_new_user_verification"] = ["code"=>"system_new_user_verification", "name"=>translate("tr_eda3a8920faa1af794c5af503c98255d"), "mail_tpl"=>"system-new-user-verification.tpl"];
    $result["system_open_shop"] = ["code"=>"system_open_shop", "name"=>translate("tr_15ec7acc80d41d1524ad6d61311b3182"), "mail_tpl"=>"system-open-shop.tpl"];
    $result["system_edit_shop"] = ["code"=>"system_edit_shop", "name"=>translate("tr_47ddd2d7bfd2ade851ca18967474d4d0"), "mail_tpl"=>"system-edit-shop.tpl"];
    $result["system_add_stories"] = ["code"=>"system_add_stories", "name"=>translate("tr_415f4cc4723517ceecf9d92f11796e68"), "mail_tpl"=>"system-add-stories.tpl"];
    $result["system_create_ad"] = ["code"=>"system_create_ad", "name"=>translate("tr_1abe83d1461657b8e9d5516cc4d82828"), "mail_tpl"=>"system-create-ad.tpl"];
    $result["system_add_complaint_user"] = ["code"=>"system_add_complaint_user", "name"=>translate("tr_b68e06d07f106fd117dafd69621b849d"), "mail_tpl"=>"system-add-complaint-user.tpl"];
    $result["system_add_complaint_ad"] = ["code"=>"system_add_complaint_ad", "name"=>translate("tr_b49622aea11073783fae89184450c5c7"), "mail_tpl"=>"system-add-complaint-ad.tpl"];

    return $result;

}

public function actionsCodeSystem(){ 
    global $app;

    $result["system_new_users"] = ["code"=>"system_new_users", "name"=>translate("tr_2fbd8719f2595bbe4fc24646e945e9a5")];
    $result["system_new_transaction"] = ["code"=>"system_new_transaction", "name"=>translate("tr_45f8547c14a487ecbd3f6e190adc2e9e")];
    $result["system_chat_new_message"] = ["code"=>"system_chat_new_message", "name"=>translate("tr_363c284d56019dea9412200a37c20815")];
    $result["system_open_dispute_deal"] = ["code"=>"system_open_dispute_deal", "name"=>translate("tr_e1fc430809c38206dce521425fcf125f")];
    $result["system_new_user_verification"] = ["code"=>"system_new_user_verification", "name"=>translate("tr_eda3a8920faa1af794c5af503c98255d")];
    $result["system_open_shop"] = ["code"=>"system_open_shop", "name"=>translate("tr_15ec7acc80d41d1524ad6d61311b3182")];
    $result["system_edit_shop"] = ["code"=>"system_edit_shop", "name"=>translate("tr_47ddd2d7bfd2ade851ca18967474d4d0")];
    $result["system_add_stories"] = ["code"=>"system_add_stories", "name"=>translate("tr_415f4cc4723517ceecf9d92f11796e68")];
    $result["system_create_ad"] = ["code"=>"system_create_ad", "name"=>translate("tr_1abe83d1461657b8e9d5516cc4d82828")];
    $result["system_create_review"] = ["code"=>"system_create_review", "name"=>translate("tr_0cf94cfe98786602760056058733729e")];
    $result["system_add_complaint_user"] = ["code"=>"system_add_complaint_user", "name"=>translate("tr_b68e06d07f106fd117dafd69621b849d")];
    $result["system_add_complaint_ad"] = ["code"=>"system_add_complaint_ad", "name"=>translate("tr_b49622aea11073783fae89184450c5c7")];
    
    return $result;

}

public function addWaiting(){
    global $app;

    if(isset($this->code)){

        $app->model->users_waiting_notifications->insert(["time_create"=>$app->datetime->getDate(), "params"=>$this->params ? _json_encode($this->params) : null, "action_code"=>$this->code, "user_id"=>$this->userId?:0]);

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

}

public function code($code=null)
{
    $this->code = $code;
    return $this;
}

public function getActionCode($name=null){
    global $app;

    $actionsCode = $this->actionsCode();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}

public function getActionCodeSystem($name=null){
    global $app;

    $actionsCode = $this->actionsCodeSystem();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}

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

public function macrosList(){
    global $app;

    $geo = getGeolocation();

    return [
        "{domain}"=>getHost(true),
        "{city}"=>$geo["city"],
        "{ip}"=>getIp(),
        "{project_name}"=>$app->settings->project_name,
        "{project_title}"=>$app->settings->project_title,
        "{dashboard_link}"=>getUrlDashboard(),
        "{logo}"=>$app->storage->host(true)->logo(),
        "{logo_mini}"=>$app->storage->host(true)->logoMini(),
    ];
    
}

public function params($params=[])
{
    $this->params = $params;
    return $this;
}

public function sendByUser(){
    global $app;

    if(isset($this->code) && isset($this->userId)){

        $this->params["chat_id"] = $this->user->messenger_token_id;

        if($this->user->notifications_method == "email"){
            $this->sendEmail();
        }elseif($this->user->notifications_method == "telegram"){
            if($this->user->messenger_token_id){
                $this->sendMessenger("telegram");
            }else{
                $this->sendEmail();
            }
        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

}

public function sendEmail(){
    global $app;

    $to = null;
    $result = [];
    $macrosList = $this->macrosBuild();

    if(isset($this->to)){
        $to = $this->to;
    }elseif(isset($this->user)){
        $to = $this->user->email;
    }

    if(isset($to)){

        $getActionCode = $app->notify->getActionCode($this->code);

        if($getActionCode){

            if(file_exists($app->config->resource->mail->path.'/'.$getActionCode->mail_tpl)){

                $subject = $getActionCode->name;
                $body = obContent($app->config->resource->mail->path.'/'.$getActionCode->mail_tpl);

                foreach($macrosList AS $key => $value){
                    $body = str_replace($key, $value, $body);
                    $subject = str_replace($key, $value, $subject);
                }

                $result = $app->mailer->body(['subject'=>$subject,'body'=>$body, 'attachments'=>$this->params['attachments']?:null])->to($to)->send();   
                            
            }

        }else{

            foreach($macrosList AS $key => $value){
                $this->params['text'] = str_replace($key, $value, $this->params['text']);
                $this->params['subject'] = str_replace($key, $value, $this->params['subject']);
            }

            $result = $app->mailer->body(['subject'=>$this->params['subject'],'body'=>$this->params['text'], 'attachments'=>$this->params['attachments']?:null])->to($to)->send();

        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    return $result;

}

public function sendMessageFirebase($params = []){
    global $app;

    if(!$app->settings->api_app_firebase_push_params || !$params['token']) return false;

    try {

        $data = _json_decode(decrypt($app->settings->api_app_firebase_push_params));

        if(strtotime($app->settings->api_app_firebase_bearer_expires_in) <= time() || !$app->settings->api_app_firebase_bearer_expires_in){

            $client = new \Google\Client();

            $client->setAuthConfig($data);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();

            if($token['access_token']){

                $app->model->settings->update(date('Y-m-d H:i:s', intval($token['created'])+intval($token['expires_in'])),"api_app_firebase_bearer_expires_in");
                $app->model->settings->update(encrypt($token['access_token']),"api_app_firebase_bearer");
                $fbm_bearer = $token['access_token'];

            }else{
                logger("Firebase: ".print_r($token, true));
                return false;
            }

        }else{
            $fbm_bearer = decrypt($app->settings->api_app_firebase_bearer);
        }

        $ch = curl_init();

        $headers = array(
            'Authorization: Bearer '.$fbm_bearer,
            'Content-Type: application/json'
        );

        $body = [
            'message' => [
               'token' => $params['token'],
               'notification' => [
                    "title" => (String)$params['title'],
                    "body" => (String)$params['text'],
               ],
               'data' => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "screen" => $params['screen'] ? (String)$params['screen'] : 'chat',
                    "dialogue_token" => $params['dialogue_token'] ? (String)$params['dialogue_token'] : null,
                    "whom_user_id" => $params['whom_user_id'] ? (String)$params['whom_user_id'] : null,
                    "from_user_id" => $params['from_user_id'] ? (String)$params['from_user_id'] : null,
                    "channel_id" => $params['channel_id'] ? (String)$params['channel_id'] : null,
                    "ad_id" => $params['ad_id'] ? (String)$params['ad_id'] : null,
                ],
                "android" => [
                    "notification" => [
                        "sound" => "default",
                    ],
                    "priority" => "high",
                ],    
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default",
                        ],
                    ]
                ],
            ],
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$data["project_id"]}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, _json_encode($body));

        $answer = _json_decode(curl_exec($ch));

        curl_close($ch);

        if(empty($answer['error'])){
            return true;
        }else{
            logger("Firebase: ".print_r($answer['error'], true));
            return false;
        }

    } catch (Exception $e) {
        logger("Firebase: {$e->getMessage()}");
        return false;
    }
 
}

public function sendMessenger($messenger=""){
    global $app;

    $text = "";
    $keyboard = [];
    $user = [];
    $whomUser = [];
    $result = [];

    $macrosList = $this->macrosBuild();

    if($this->code){

        if($this->code == "system_new_users"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_84438949b14f6252243fe32b0ccfad9f")."\n";
            $text .= translate("tr_d38d6d925c80a2267031f3f03d0a9070")." - {user_name}\n";
            $text .= translate("tr_7a176a6a64c888d6496097dc0440cbc3")." - {user_email}\n";
            $text .= translate("tr_2928e19c705428df3c9f1e6d4ea8042f")." - {user_phone}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>getUrlDashboard().'/user/card/'.$this->params["user_id"], 'text'=>translate("tr_099eb541519b8a89eea93fae6c83fb07")]
                    ]
                ]
            ];

        }elseif($this->code == "system_new_transaction"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_acc4aaa58138e86ce4e9d4beb2ed23c2")." {amount}\n";
            $text .= translate("tr_dfde1ffd136702faa5d88f9317918b49") . " - {transaction_name}\n";
            $text .= translate("tr_91a72f953017cf1888e332146adacd83") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>getUrlDashboard().'/user/card/'.$this->params["user_id"], 'text'=>translate("tr_099eb541519b8a89eea93fae6c83fb07")]
                    ]
                ]
            ];

        }elseif($this->code == "system_chat_new_message"){

            $text = "<b>{project_name}</b>\n";
            $text .= "✉{message_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-chat", [], true), 'text'=>translate("tr_1299ff65057c53c4512f4e3958f28216")]
                    ]
                ]
            ];

        }elseif($this->code == "system_open_dispute_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_3f870f5c746cd3ea3c547981119023e4") . " №{order_id}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-deal-card", [$this->params["order_id"]], true), 'text'=>translate("tr_55ae6e6aa3ddc52d8f369deebd2afab9")]
                    ]
                ]
            ];

        }elseif($this->code == "system_new_user_verification"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_2d878a54f60ccca3b5b25d03d96379b8") . " {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-users-verifications", [], true), 'text'=>translate("tr_76ccf661fc25a07cc57c9f538c9bc244")]
                    ]
                ]
            ];

        }elseif($this->code == "system_open_shop"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_7e79418fc78b28008077711cb9f90fb0")."\n";
            $text .= translate("tr_602680ed8916dcc039882172ef089256") . " - {shop_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-shops", [], true), 'text'=>translate("tr_4c8c33a521ae06f772b6efbd20ffefca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_edit_shop"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_f579c45ab1bee9ea3cfb3028a5dbe591") . " <b>{shop_name}</b> " . translate("tr_0e28049785706e06eb4f57148f2aed4a")."\n";

            if($this->params["action"] == "edit_shop"){
                $text .= translate("tr_191e2d9893e5052b6300a5a55464ca1a")."\n";
            }elseif($this->params["action"] == "add_banner_shop"){
                $text .= translate("tr_ad3f358060a03f1105b59bb99e59c440")."\n";
            }elseif($this->params["action"] == "add_page_shop"){
                $text .= translate("tr_d0d2e07126398bddc73ae345db128600")."\n";
            }elseif($this->params["action"] == "edit_page_text_shop"){
                $text .= translate("tr_b834b3cd193b4e7ded55ca4b33ab3bc9") . " <b>{page_name}</b>\n";
            }
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-shops", [], true), 'text'=>translate("tr_4c8c33a521ae06f772b6efbd20ffefca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_stories"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_76215bba4518064d5af4218ff6a82f73") . " {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-stories", [], true), 'text'=>translate("tr_db4409f9f1ea52fac92952bb9f5fea57")]
                    ]
                ]
            ];

        }elseif($this->code == "system_create_ad"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_0c65560f21894bd6f44cbf26f0b2ecde")."\n";
            $text .= translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0")." - {ad_title}\n";
            $text .= translate("tr_c95a1e2de00ee86634e177aecca00aed")." - {ad_category_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5")." - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-ads", [], true), 'text'=>translate("tr_e32e402c63dd8a64bfa10a4c33a648ca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_create_review"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_d803086c7492d6b9c43197040cc38771")."\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") . " - {ad_title}\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {user_name}\n";
            $text .= translate("tr_4a3f5e52678242b15f4e65f85ff3345c") . " - {review_text}\n";
            $text .= translate("tr_304ce2c8c71568195da204b85122598a") . " - {review_rating}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-reviews", [], true), 'text'=>translate("tr_2b70c86c4ee7fafdc5b45f79b60b3d10")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_complaint_user"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_e97ddccb36e7f80c57288a2ea789388d")."\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {from_user_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {whom_user_name}\n";
            $text .= translate("tr_8c45d9cf5766a98100df8108d3235247") . " - {complaint_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-complaints", [], true), 'text'=>translate("tr_81646f695bc69ab8517b793eb05ecc13")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_complaint_ad"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_fa6770e16b2917a48e6a081a919c79be")."\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {from_user_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {whom_user_name}\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") . " - {ad_title}\n";
            $text .= translate("tr_8c45d9cf5766a98100df8108d3235247") . " - {complaint_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-complaints", [], true), 'text'=>translate("tr_81646f695bc69ab8517b793eb05ecc13")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_active"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, " . translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " <b>{ad_title}</b> " . translate("tr_6b9fed28392ed2159a2e3bbd3af3f747") . "\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_4d6400738b124c2747d12988e45a84e8")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_blocked"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " <b>{ad_title}</b> ".translate("tr_2be70b953003d1fa7c2250d8a1aeb80f") . "\n";
            $text .= translate("tr_34fd5ae7f6d60c61d3a169a4d9457730") . "\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_4d6400738b124c2747d12988e45a84e8")]
                    ]
                ]
            ];

        }elseif($this->code == "user_balance_replenishment"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_7615dc29e27b7588a97802be4bd41f4d")." <b>{amount}</b>\n";

            if($this->params["text"]){
                $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";
            }

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_balance_write_downs"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_9a6796bdaca277c9418f7c63b271c6c0")." <b>{amount}</b>\n";

            if($this->params["text"]){
                $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";
            }

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "chat_new_message"){

            $text = "<b>{project_name}</b>\n";
            $text .= "✉{message_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("profile-chat", [], true), 'text'=>translate("tr_1299ff65057c53c4512f4e3958f28216")]
                    ]
                ]
            ];

        }elseif($this->code == "deal_error"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_162debde81deaa702871afde48f7a20b")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "payment_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_4c717d7d48cc9e90c80dc3d12da13dec")." №{order_id} ".translate("tr_01340e1c32e59182483cfaae52f5206f")." {amount}\n";
            $text .= translate("tr_91a72f953017cf1888e332146adacd83")." - {from_user_name}\n";
            $text .= translate("tr_dfde1ffd136702faa5d88f9317918b49")." - {ad_title}\n";
            $text .= translate("tr_cb8bfd4d5a1df2e7459f2fe740c8dcba")." - {count}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "create_order_booking"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_e7d50c90e6acb758da5b7bf59b97aa29")." <b>{ad_title}</b>\n";
            $text .= translate("tr_64cdb8db21af169518cc6d997fb81086")."\n";
            $text .= translate("tr_4af22f2d58c928ab7557d204d2459eb6")." - {from_user_name}\n";
            $text .= translate("tr_b36933fc385983497bde945fb80b33ab")." - {contact_user_name}, {contact_user_phone}, {contact_user_email}\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d")." - {ad_title}\n";
            $text .= translate("tr_cf59ebf9edf7ebe3ece76645abb6de12")." - {amount}\n";
            $text .= translate("tr_2f2763f1cb99164e85834505b62073b4")." - {date_start} - {date_end}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "confirmed_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_c6ff3b2901b7ad603f6194c379ba36ea")." №{order_id} ".translate("tr_ea3084ce9163cd1760abfde3299448df")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "change_status_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_0c0e6862441b4b3171efd93e8bad3e6b")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "open_dispute_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_f58a6ebf6da1e8327cfe28485303672e")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "cancel_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_9d7ec5f642a6e239d290cfa6472da300")." №{order_id} ".translate("tr_71dd64eab0b03532e8de9d7b301ecf9f")."\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_241473bf17f1e2f6de8f9d30c64d07b6")." <b>{ad_title}</b> ".translate("tr_b436e6bef8319354dc254aedfd9f800a")."\n";
            $text .= translate("tr_c81290eac4d93d8fd2c5a7d6df785ee6")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_fafc7b5705bdb2dfa438a7b671dfb3a0")]
                    ]
                ]
            ];

        }elseif($this->code == "service_tariff_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_bd0b7b3c2d89b87127345a0ffcf81dbb")."\n";
            $text .= translate("tr_55a5e47bfd8a64bf7236c86f650c84cc")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "soon_service_tariff_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_b00f1f02f709c2f60dbf70203834e1c8")."\n";
            $text .= translate("tr_7e4aafa0dfcdce51bb3f81c0d7dfe71a")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "referral_accrued_award"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_90572379599960fa66c82c50aa518b57")." {amount} ".translate("tr_6c992b9574206303414ac2f55e2d4076")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_verification_verified"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_66e318c5b65e5331afd8e99baef1295d")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_verification_rejected"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_f60af68724eaba8ff066e514f827eb22")."\n";
            $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_shop_published"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_0b0b1a8dcca2868225a61ecc9cc33224")." <b>{shop_name}</b> ".translate("tr_c614f0409f21d4cb4bedfea31b11260c")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["shop_link"], 'text'=>translate("tr_35cdd14da9661e80ab00d05c44335c2d")]
                    ]
                ]
            ];

        }elseif($this->code == "user_shop_rejected"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_e130ea3d7b0fc42b53639ee0598207cb")." <b>{shop_name}</b> ".translate("tr_c94e6d358ab8da0118d2353a7e4fd982")."\n";
            $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["shop_link"], 'text'=>translate("tr_35cdd14da9661e80ab00d05c44335c2d")]
                    ]
                ]
            ];

        }


    }else{

        $text = $this->params["text"];

    }

    if($macrosList){
        foreach ($macrosList as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
    }

    $result = $app->addons->messenger($messenger)->sendMessage(["chat_id"=>$this->params["chat_id"], "text"=>$text, "keyboard"=>$keyboard]);

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    return $result;

}

public function sendReport($data=[]){
    global $app;

    $result = '';

    foreach ($data as $key => $value) {

        if($key == "transactions_amount"){

            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.numberFormat($value->count,2) . ' ' . $app->system->getDefaultCurrency()->code.'</td>
                    </tr>
            ';

        }elseif($key == "users_traffic"){
            
            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.' '.endingWord($value->count, translate("tr_e457d998e4f41614ef24902a655fd86f"), translate("tr_738df4403f3662927ce7424f7abbafb4"), translate("tr_e457d998e4f41614ef24902a655fd86f")).'</td>
                    </tr>
            ';

        }elseif($key == "users"){
            
            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.' '.endingWord($value->count, translate("tr_e457d998e4f41614ef24902a655fd86f"), translate("tr_738df4403f3662927ce7424f7abbafb4"), translate("tr_e457d998e4f41614ef24902a655fd86f")).'</td>
                    </tr>
            ';

        }else{

            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.'</td>
                    </tr>
            ';

        }

    }

    $template = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        
        <style type="text/css">

        @import url("https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext");
        body {font-family: "Roboto", sans-serif; font-size: 14px;}
        table {margin: 0 0 15px 0;width: 100%;border-collapse: collapse;border-spacing: 0;}     
        table th {padding: 5px;font-weight: bold;}        
        table td {padding: 5px;}    

        h1 {margin: 0 0 10px 0;padding: 10px 0;border-bottom: 2px solid #000;font-weight: bold;font-size: 20px;}
            
        .list thead, .list tbody  {border: 2px solid #000; width: 100%; }
        .list thead th {padding: 4px 0;border: 1px solid #000;vertical-align: middle;text-align: center;}   
        .list tbody td {padding: 10px;border: 1px solid #000;vertical-align: middle;font-size: 14px;}    
        .list tfoot th {padding: 3px 2px;border: none;text-align: right;}   
     
        .logo{ width: 150px; }

        </style>
    </head>
    <body>
     
        <div class="logo" ><img src="{logo}" /></div>
     
        <h1>'.translate("tr_a35eccff74655ccf90feda2704ee3ab6").' '.$app->settings->system_report_last_time_generation.' '.translate("tr_22d57c9399ca22ffbe414f057e8ff6dc").' '.$app->datetime->getDate().' '.translate("tr_f003608f862cd300f291ab8c66805fa4").' {project_name}</h1>
     
        <table class="list">
            <tbody>
            
                '.$result.'

            </tbody>
        </table>
        
    </body>
    </html>
    ';

    foreach($this->macrosList() AS $macrosKey => $macrosValue){
        $template = str_replace($macrosKey, $macrosValue, $template);
    }

    $filename = $app->doc->pdf($template);

    if($app->settings->system_report_recipients_ids){

        if(is_array($app->settings->system_report_recipients_ids)){

            $getUsers = $app->model->users->getAll("id IN(".implode(",", $app->settings->system_report_recipients_ids).")");

            if($getUsers){
                foreach ($getUsers as $key => $value) {
                    if($value["messenger_token_id"] && $app->settings->integration_messenger_service){
                        $app->addons->messenger($app->settings->integration_messenger_service)->sendDocument(["text"=>translate("tr_f7e7bb3adb7bd115d9b21d37f1dfb468")." ".$app->settings->project_name, "filename"=>$filename, "chat_id"=>$value["messenger_token_id"]]);
                    }else{
                        $this->params(["link"=>path($filename, true), "user_name"=>$value["name"], "user_email"=>$value["email"]])->code("system_report")->to($value["email"])->sendEmail();
                    }
                }
            }

        }

    }

}

public function sendVerifyCode(){
    global $app;

    $answer = [];

    $params = $this->params;
    $code = $this->code;
    $user_id = $this->userId;
    $to = $this->to;

    if(isset($code)){

        $result = $this->sendEmail();

        if($result){
            $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
            $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_ceaa0361d1a7f798460364acecdf7437")];
        }else{
            $answer = ["status"=>false, "answer"=>translate("tr_eaf72927132caf9363e1382e59040976")];
        }

    }else{

        if($app->settings->phone_confirmation_service == "sms"){
            if($app->settings->integration_sms_service){

                $result = $app->addons->sms($app->settings->integration_sms_service)->send(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                if($result["status"] == true){

                    if($result["code"]){
                        $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                        $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_6977ca512793da7400e2dca8076b556f")];
                    }elseif($result["call_phone"]){
                        $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "service_internal_id"=>$result["service_internal_id"]?:null, "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                        $answer = ["status"=>true, "method"=>"call_phone", "call_phone"=>$result["call_phone"], "title"=>translate("tr_2fef908acd6aa0263c29833ab5ddb2ac")];
                    }

                }else{
                    $answer = ["status"=>false, "answer"=>translate("tr_ed7008d39fcad0962b27dde9a57a7287")];
                }

            }
        }elseif($app->settings->phone_confirmation_service == "messenger"){
            if($app->settings->integration_messenger_service){

                $result = $app->addons->messenger($app->settings->integration_messenger_service)->sendVerifyCode(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                if($result["status"] == true){

                    $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);

                    $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_cccb8532ba3d9c2d1249ba38187be66b")];

                }else{

                    if($app->settings->integration_sms_service){

                        $result = $app->addons->sms($app->settings->integration_sms_service)->send(["to"=>$to, "text"=>$params["text"], "code"=>$params["code"]]);

                        if($result["status"] == true){

                            if($result["code"]){
                                $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "code"=>$params["code"], "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                                $answer = ["status"=>true, "method"=>"code", "title"=>translate("tr_6977ca512793da7400e2dca8076b556f")];
                            }elseif($result["call_phone"]){
                                $app->model->users_waiting_verify_code->insert(["contact"=>$to, "session_id"=>$params["session_id"]?:null, "service_internal_id"=>$result["service_internal_id"]?:null, "time_create"=>$app->datetime->getDate(), "ip"=>getIp()]);
                                $answer = ["status"=>true, "method"=>"call_phone", "call_phone"=>$result["call_phone"], "title"=>translate("tr_2fef908acd6aa0263c29833ab5ddb2ac")];
                            }

                        }else{
                            $answer = ["status"=>false, "answer"=>translate("tr_ed7008d39fcad0962b27dde9a57a7287")];
                        }

                    }

                }

            }
        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    if($answer){
        return $answer;
    }else{
        return ["status"=>false, "answer"=>translate("tr_ef796f8fc3ce669548fb22bb06b53c17")];
    }
    
}

public function to($to=null)
{
    $this->to = $to;
    return $this;
}

public function userId($id=null)
{
    global $app;
    $this->user = $id ? $app->model->users->find("id=?", [$id]) : [];
    $this->userId = $id;
    return $this;
}



 }