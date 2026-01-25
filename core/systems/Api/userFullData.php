public function userFullData($user=[]){
    global $app;

    $favorites = [];
    $shop = [];
    $orders = [];

    $getFavorites = $app->model->users_favorites->getAll("user_id=?", [$user->id]);

    if($getFavorites){
        foreach ($getFavorites as $value) {
            $favorites[] = $value["ad_id"];
        }
    }

    $getOrders = $app->model->transactions_deals->sort("time_update desc")->getAll("(from_user_id=? or whom_user_id=?) and status_completed=? and status_processing!=?", [$user->id, $user->id, 0, "cancel_order"]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {

            $orders[] = [
                "id"=>$value["id"],
                "order_id"=>(String)$value["order_id"],
                "title"=>translate("tr_4d406f4dcd44a95252f06163a3cdcb5e")." ".$app->datetime->outDate($value["time_create"])." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$app->system->amount($value["amount"]),
                "status"=>$value["status_processing"],
                "status_name"=>$app->component->transaction->getStatusDeal($value["status_processing"])->name,
                "from_user_id"=>$value["from_user_id"],
                "whom_user_id"=>$value["whom_user_id"],
            ];

        }
    }

    $shop = $app->model->shops->find("user_id=?", [$user->id]);
    $countAds = $app->model->ads_data->count("user_id = ? and status = ?", [$user->id,1]);
    $countSubscribers = $app->model->users_subscriptions->count("whom_user_id = ?", [$user->id]);

    $notifications = $user->notifications ? _json_decode($user->notifications) : [];
    $contacts = $user->contacts ? _json_decode(decrypt($user->contacts)) : [];

    $payments = $app->model->users_payment_data->getAll("user_id=?", [$user->id]);
    if($payments){
        foreach ($payments as $key => $value) {
            $value["score"] = decrypt($value["score"]);
            $payments_score_list[] = ["id"=>$value["id"], "default_status"=>$value["default_status"] ? true : false, "score"=>"**** **** **** ".substr($value["score"], strlen($value["score"])-4, strlen($value["score"]))];
        }
    }

    $points = $app->model->users_shipping_points->getAll("user_id=?", [$user->id]);

    if($points){
        foreach ($points as $key => $value) {
           $delivery = $app->model->system_delivery_services->find("id=?", [$value["delivery_id"]]);
           if($delivery){
               $shipping_points[] = ["logo"=>$app->addons->delivery($delivery->alias)->logo(), "name"=>$delivery->name, "address"=>$value["address"]];
           }
        }
    }

    $getBonuses = $app->model->users_bonuses_fortune->find("user_id=? order by time_create desc", [$user->id]);

    if($getBonuses){
        $fortune_bonus_status = date("Y-m-d", strtotime($getBonuses->time_create)) == date("Y-m-d") ? false : true;
        $time = strtotime(date('d.m.Y 23:59'));
        $diff = $time - time();
        $fortune_bonus_remained_time = $diff;
    }else{
        $fortune_bonus_status = true;
        $fortune_bonus_remained_time = null;
    }

    $deliveryData = $app->model->users_delivery_data->find("user_id=?", [$user->id]);

    return [
        "id" => $user->id,
        "display_name" => $user->name,
        "name" => $user->name,
        "surname" => $user->surname,
        "password" => $user->password ?: null,
        "notifications_method" => $user->notifications_method,
        "notifications_list" => $notifications ? ["chat"=>$notifications["chat"] ? true : false, "expiration_ads"=>$notifications["expiration_ads"] ? true : false, "expiration_tariff"=>$notifications["expiration_tariff"] ? true : false] : null,
        "uniq_hash" => $user->uniq_hash,
        "messenger_notification_link" => ["telegram"=>outUserLinkTelegramBot($user->uniq_hash)],
        "contacts" => ["email"=>$user->email ? $this->encryptAES($user->email) : null, "phone"=>$user->phone ? $this->encryptAES($user->phone) : null, "whatsapp"=>$contacts["whatsapp"] ? $this->encryptAES($contacts["whatsapp"]) : null, "telegram"=>$contacts["telegram"] ? $this->encryptAES($contacts["telegram"]) : null, "max"=>$contacts["max"] ? $this->encryptAES($contacts["max"]) : null],
        "organization_name" => $user->organization_name ?: "",
        "user_status" => $user->user_status == 1 ? "user" : "company",
        "alias" => $user->alias,
        "avatar" => $app->storage->name($user->avatar)->host(true)->get(),
        "rating" => sprintf("%.1f", $user->total_rating),
        "reviews" => $user->total_reviews,
        "reviews_label" => $user->total_reviews . " " . endingWord($user->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")),
        "uniq_hash" => $user->uniq_hash,
        "status" => $user->status,
        "mode_online" => $this->userActivityStatus($user->time_last_activity),
        "shop" => $shop ? [
            "id"=>$shop->id,
            "title"=>$shop->title,
            "logo"=>$app->storage->name($shop->image)->host(true)->get(),
            "text"=>$shop->text,
        ] : null,
        "verification_status" => $user->verification_status ? true : false,
        "balance" => $user->balance,
        "balance_formatted" => $app->system->amount($user->balance),
        "tariff" => $this->usersServiceTariffData($user->id, $user->tariff_id) ?: null,
        "count_ads" => $countAds,
        "subscribers_count" => $countSubscribers,
        "orders" =>$orders ?: null,
        "ref_programm" => null,
        "tariff_id" => $user->tariff_id,
        "stories" => $this->usersStoriesData($user->id) ?: null,
        "favorites_ids" => $favorites?:null,
        "status_text" => $user->card_status_text ?: null,
        "delivery_status" => $user->delivery_status ? true : false,
        "ref_programm" => $app->settings->referral_program_status ? ["text"=>translate("tr_7cfdcea83842225d7c79b2b4b46a37eb")." ".$app->settings->referral_program_percent_award.translate("tr_db52586c384d927c18692bc5f5672950"), "link"=>getHost() . '/ref/' . $user->alias] : null,
        "payments_score_list" => $payments_score_list ?: [],
        "shipping_points" => $shipping_points ?: [],
        "fortune_bonus_status" => $fortune_bonus_status ? true : false,
        "fortune_bonus_remained_time" => $fortune_bonus_remained_time,
        "delivery_data"=>$deliveryData ? ["name"=>$deliveryData->name, "surname"=>$deliveryData->surname, "phone"=>$this->encryptAES(decrypt($deliveryData->phone)), "email"=>$this->encryptAES(decrypt($deliveryData->email))] : null,
    ];
}