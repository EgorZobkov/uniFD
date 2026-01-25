public function statisticReportByHours(){
    global $app;

    $result = [];

    $result["users_traffic"] = ["name"=>translate("tr_d664efd59401f509ad4ed40efd99fad1"), "count"=>$app->model->traffic_report->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["users"] = ["name"=>translate("tr_5fa90e66fe2996d856e966858464b41e"), "count"=>$app->model->users->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["ads"] = ["name"=>translate("tr_0c1f524fbb63b2da064e49ce614af003"), "count"=>$app->model->ads_data->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["transactions"] = ["name"=>translate("tr_77f9b85e7d01590d032f2855362be8f7"), "count"=>$app->model->transactions->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["transactions_amount"] = ["name"=>translate("tr_7bd619f38bbbe73528f93fb7a276d98a"), "count"=>$app->db->getSumByTotal("amount", "uni_transactions", "time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["reviews"] = ["name"=>translate("tr_6e1481c558a14cbcdcabb9a0af726f4e"), "count"=>$app->model->reviews->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", [1])];
    $result["complaints"] = ["name"=>translate("tr_2f9b9237fd75c2a08052eb443ac81458"), "count"=>$app->model->complaints->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", [1])];
    $result["deals"] = ["name"=>translate("tr_a2cd08bbbe3c1bea939897a780561a1c"), "count"=>$app->model->transactions_deals->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR)")];
    $result["users_verifications"] = ["name"=>translate("tr_cc39f940e4267e4311c0e61bc5892809"), "count"=>$app->model->users_verifications->count("time_create >= DATE_SUB(NOW(),INTERVAL ".$app->settings->system_report_period." HOUR) and status=?", ['awaiting_verification'])];

    return arrayToObject($result);

}