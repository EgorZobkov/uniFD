    public function userData($user=[]){
        global $app;

        $shop = [];

        $shop = $app->component->shop->getActiveShopByUserId($user->id);
        $countAds = $app->model->ads_data->count("user_id = ? and status = ?", [$user->id,1]);
        $countSubscribers = $app->model->users_subscriptions->count("whom_user_id = ?", [$user->id]);
        
        return [
            "id" => $user->id,
            "display_name" => $user->name,
            "name" => $user->name,
            "surname" => $user->surname,
            "contacts" => $contacts ?: null,
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
            "orders" =>null,
            "ref_programm" => null,
            "tariff_id" => $user->tariff_id,
            "stories" => $this->usersStoriesData($user->id) ?: null,
            "status_text" => $user->card_status_text ?: null,
            "delivery_status" => $user->delivery_status, 
        ];
    }