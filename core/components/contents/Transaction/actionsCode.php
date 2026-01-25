public function actionsCode(){   
    global $app;

    $result["user_balance"] = ["code"=>"user_balance", "name"=>translate("tr_4794c3c39a4578aa6096bf3ced5d5a89"), "template"=>translate("tr_4794c3c39a4578aa6096bf3ced5d5a89")];
    $result["paid_ad_services"] = ["code"=>"paid_ad_services", "name"=>translate("tr_69e15c68de676d2fd96c2f1be07206ca"), "template"=>translate("tr_69e15c68de676d2fd96c2f1be07206ca")." - {service_name} ".translate("tr_1f6c150ae7fba44b3897f51c51c4ca47")." {service_count_day}"];
    $result["service_tariff"] = ["code"=>"service_tariff", "name"=>translate("tr_77ce3f2a493b6c2d4d60d7150e66a819"), "template"=>translate("tr_77ce3f2a493b6c2d4d60d7150e66a819")." - {tariff_name} ".translate("tr_1f6c150ae7fba44b3897f51c51c4ca47")." {tariff_count_day}"];
    $result["paid_category"] = ["code"=>"paid_category", "name"=>translate("tr_c555584a25bfff6c85b1f3e3835f4ff7"), "template"=>translate("tr_4f28d671f86a6da6ca38d7609036510f")." - {category_name}"];
    $result["user_stories"] = ["code"=>"user_stories", "name"=>translate("tr_ba1fb533d4411243e29c80dfccb00686"), "template"=>translate("tr_ba1fb533d4411243e29c80dfccb00686")];
    $result["secure_deal"] = ["code"=>"secure_deal", "name"=>translate("tr_c21b2ddff1f121219f81a576c5f6a242"), "template"=>translate("tr_c21b2ddff1f121219f81a576c5f6a242")];

    return $result;

}