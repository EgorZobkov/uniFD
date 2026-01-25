public function statusesOperation(){   
    global $app;

    $result["awaiting_payment"] = ["code"=>"awaiting_payment", "name"=>translate("tr_47f1f18a961cd149db1dc53ba4b31b37"), "label"=>"warning"];
    $result["paid"] = ["code"=>"paid", "name"=>translate("tr_6d8c0850821a806217ea219a53500d7e"), "label"=>"success"];
    $result["awaiting_refund"] = ["code"=>"awaiting_refund", "name"=>translate("tr_70bd7e5b717141e953d88d9f553e6e38"), "label"=>"warning"];
    $result["refund"] = ["code"=>"refund", "name"=>translate("tr_528182826de2acb5dbb4957010d182f1"), "label"=>"warning"];
    $result["error"] = ["code"=>"error", "name"=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"), "label"=>"danger"];
    return $result;

}