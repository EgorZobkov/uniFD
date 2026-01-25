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