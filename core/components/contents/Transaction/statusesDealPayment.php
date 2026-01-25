public function statusesDealPayment(){   
    global $app;

    $result["awaiting_payment"] = ["code"=>"awaiting_payment", "name"=>translate("tr_1f1016ebd265f71f6cf4c8e61fcf4e33"), "label"=>"warning"];
    $result["done"] = ["code"=>"done", "name"=>translate("tr_188d7d98dd1b53c85b203f802e1fdf86"), "label"=>"success"];
    $result["no_score"] = ["code"=>"no_score", "name"=>translate("tr_5557733260d5065a26cfef9addeba834"), "label"=>"warning"];
    $result["payment_error"] = ["code"=>"payment_error", "name"=>translate("tr_f53c9b2f925be0923418892c449b56d4"), "label"=>"danger"];

    return $result;

}