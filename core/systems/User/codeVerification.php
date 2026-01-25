public function codeVerification(){   
    global $app;

    $result["awaiting_verification"] = ["code"=>"awaiting_verification", "name"=>translate("tr_415e61b1b8e1ead55cf24792dd8da945"), "label"=>"warning"];
    $result["verified"] = ["code"=>"verified", "name"=>translate("tr_93fac5956a123559ab44a812038a7ea8"), "label"=>"success"];
    $result["rejected"] = ["code"=>"rejected", "name"=>translate("tr_7c1a8fcbf63d6f7fa992bd34949a37c1"), "label"=>"secondary"];

    return $result;

}