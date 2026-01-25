public function statusesDeal(){   
    global $app;

    $result["awaiting_confirmation"] = ["code"=>"awaiting_confirmation", "name"=>translate("tr_f4636fd16e2df3445885f06db1a06d9c"), "label"=>"secondary"];
    $result["confirmed_order"] = ["code"=>"confirmed_order", "name"=>translate("tr_361a6154ef972d6614ecc80b9acf7d2e"), "label"=>"success"];
    $result["confirmed_send_shipment"] = ["code"=>"confirmed_send_shipment", "name"=>translate("tr_e245d6ddf9eb6c8222c2ec39471ee4e1"), "label"=>"warning"];
    $result["confirmed_transfer"] = ["code"=>"confirmed_transfer", "name"=>translate("tr_a856a106ecccf40ec49b1b6f45d1618d"), "label"=>"success"];
    $result["confirmed_completion_service"] = ["code"=>"confirmed_completion_service", "name"=>translate("tr_1db8895111a4f059392893d800a3c8f1"), "label"=>"warning"];
    $result["access_open"] = ["code"=>"access_open", "name"=>translate("tr_1c4d017c1c6df12c58500bd0de14d58a"), "label"=>"success"];
    $result["completed_order"] = ["code"=>"completed_order", "name"=>translate("tr_245743d5301f067be6cb6ae479a9da7f"), "label"=>"success"];
    $result["cancel_order"] = ["code"=>"cancel_order", "name"=>translate("tr_c302fdafed8f284641ebf94309d38559"), "label"=>"danger"];
    $result["open_dispute"] = ["code"=>"open_dispute", "name"=>translate("tr_e1fc430809c38206dce521425fcf125f"), "label"=>"warning"];
    $result["booked"] = ["code"=>"booked", "name"=>translate("tr_793cfdfa7d5f3f9792e337cc6623dca1"), "label"=>"success"];
    return $result;

}