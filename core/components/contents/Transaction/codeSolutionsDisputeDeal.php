public function codeSolutionsDisputeDeal(){   
    global $app;

    $result["solution_completed_order"] = ["code"=>"solution_completed_order", "name"=>translate("tr_cbcae031aaf24f2be3b3cd22d4d0fb9b")];
    $result["solution_refund_full_amount"] = ["code"=>"solution_refund_full_amount", "name"=>translate("tr_70d50f48573627d943729a36c18acb75")];
    $result["solution_refund_half_amount"] = ["code"=>"solution_refund_half_amount", "name"=>translate("tr_5ec670c087456384d53cda71cc208088")];

    return $result;

}