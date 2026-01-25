public function statisticSummaryByMonth(){
    global $app;

    $result = [];

    $result["transactions_amount"] = ["name"=>translate("tr_7bd619f38bbbe73528f93fb7a276d98a"), "count"=>$app->system->amount($app->db->getSumByTotal("amount", "uni_transactions", "year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()])), "count_today"=>$app->db->getSumByTotal("amount", "uni_transactions", "date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["users"] = ["name"=>translate("tr_5fa90e66fe2996d856e966858464b41e"), "count"=>$app->model->users->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->users->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["transactions"] = ["name"=>translate("tr_77f9b85e7d01590d032f2855362be8f7"), "count"=>$app->model->transactions->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->transactions->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["ads"] = ["name"=>translate("tr_0c1f524fbb63b2da064e49ce614af003"), "count"=>$app->model->ads_data->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->ads_data->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["deals"] = ["name"=>translate("tr_a2cd08bbbe3c1bea939897a780561a1c"), "count"=>$app->model->transactions_deals->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->transactions_deals->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["reviews"] = ["name"=>translate("tr_6e1481c558a14cbcdcabb9a0af726f4e"), "count"=>$app->model->reviews->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->reviews->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["complaints"] = ["name"=>translate("tr_2f9b9237fd75c2a08052eb443ac81458"), "count"=>$app->model->complaints->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->complaints->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];
    $result["users_verifications"] = ["name"=>translate("tr_92b89c7ae75b0cd8e9389022ffde6182"), "count"=>$app->model->users_verifications->count("year(time_create) = ? and month(time_create) = ?", [$app->datetime->currentYear(), $app->datetime->currentMonth()]), "count_today"=>$app->model->users_verifications->count("date(time_create) = ?", [$app->datetime->format("Y-m-d")->getDate()])];

    return $result;

}