public function codeHistoryDeal(){   
    global $app;

    $result["payment"] = ["code"=>"payment", "name"=>translate("tr_d8477c7d886edaad27dabfd2cd3fb86a")];
    $result["confirmed_order"] = ["code"=>"confirmed_order", "name"=>translate("tr_361a6154ef972d6614ecc80b9acf7d2e")];
    $result["cancel_order_from_user"] = ["code"=>"cancel_order_from_user", "name"=>translate("tr_4f5e47affa437d88fbda75e49f10d9d2")];
    $result["cancel_order_whom_user"] = ["code"=>"cancel_order_whom_user", "name"=>translate("tr_0fef0dc1d1c699888353cb735f032466")];
    $result["cancel_order"] = ["code"=>"cancel_order", "name"=>translate("tr_c302fdafed8f284641ebf94309d38559")];
    $result["open_dispute"] = ["code"=>"open_dispute", "name"=>translate("tr_de30b76ad5df62bc3a7cf4e40fb4a602")];
    $result["confirmed_send_shipment"] = ["code"=>"confirmed_send_shipment", "name"=>translate("tr_e245d6ddf9eb6c8222c2ec39471ee4e1")];
    $result["confirmed_transfer"] = ["code"=>"confirmed_transfer", "name"=>translate("tr_cd8a10a7e7834f3110c614f463c297c5"), "label"=>"success"];
    $result["confirmed_completion_service"] = ["code"=>"confirmed_completion_service", "name"=>translate("tr_1db8895111a4f059392893d800a3c8f1")];
    $result["completed_order"] = ["code"=>"completed_order", "name"=>translate("tr_245743d5301f067be6cb6ae479a9da7f")];
    $result["solution_completed_order"] = ["code"=>"solution_completed_order", "name"=>translate("tr_fc8631e2143b3198e1ce686dfb69340d")];
    $result["solution_refund_full_amount"] = ["code"=>"solution_refund_full_amount", "name"=>translate("tr_70d50f48573627d943729a36c18acb75")];
    $result["solution_refund_half_amount"] = ["code"=>"solution_refund_half_amount", "name"=>translate("tr_5ec670c087456384d53cda71cc208088")];
    $result["access_open"] = ["code"=>"access_open", "name"=>translate("tr_a098d0f2c621675ccaf935f7b43fc917")];
    $result["create_booking"] = ["code"=>"create_booking", "name"=>translate("tr_a5e888318623883ca17d89ac0a253cb6")];

    return $result;

}