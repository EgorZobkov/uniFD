public function statisticWaitingAction(){
    global $app;

    $result = [];

    $ads = $app->model->ads_data->count("status=?", [0]);

    if($ads){
        $result[] = ["name"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"), "count"=>$ads, "link"=>$app->router->getRoute("dashboard-ads").'?filter[status]=0'];
    }

    $users_verifications = $app->model->users_verifications->count("status=?", ["awaiting_verification"]);

    if($users_verifications){
        $result[] = ["name"=>translate("tr_0fee6aa9a8fb2dea58559f63f73191fc"), "count"=>$users_verifications, "link"=>$app->router->getRoute("dashboard-users-verifications").'?filter[status]=awaiting_verification'];
    }

    $reviews = $app->model->reviews->count("status=?", [0]);

    if($reviews){
        $result[] = ["name"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa"), "count"=>$reviews, "link"=>$app->router->getRoute("dashboard-reviews").'?filter[status]=0'];
    }

    $complaints = $app->model->complaints->count("status=?", [0]);

    if($complaints){
        $result[] = ["name"=>translate("tr_0a60111d2b41f343bed6a257a4c13d0d"), "count"=>$complaints, "link"=>$app->router->getRoute("dashboard-complaints").'?filter[status]=0'];
    }

    $shops = $app->model->shops->count("status=?", ["awaiting_verification"]);

    if($shops){
        $result[] = ["name"=>translate("tr_cfb8af01cc910b08e8796e03cf662f5f"), "count"=>$shops, "link"=>$app->router->getRoute("dashboard-shops").'?filter[status]=awaiting_verification'];
    }

    $deals = $app->model->transactions_deals->count("status_processing=?", ["open_dispute"]);

    if($deals){
        $result[] = ["name"=>translate("tr_b0dc896806dedb7c1e2e5598905315a0"), "count"=>$deals, "link"=>$app->router->getRoute("dashboard-deals").'?filter[status]=open_dispute'];
    }

    return $result;

}