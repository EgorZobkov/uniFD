public function actionsCode(){   
    global $app;

    $result["system_registration"] = ["code"=>"system_registration", "name"=>translate("tr_2fbd8719f2595bbe4fc24646e945e9a5"), "default_text"=>translate("tr_42dcb0688bf81f577abae9a24a5c89cc")];
    $result["system_create_order"] = ["code"=>"system_create_order", "name"=>translate("tr_bae21bd72d8b2119fde3b9a06e3fadd1"), "default_text"=>translate("tr_93c26db2cc5b20535a12240a84a54bbc")];
    $result["system_warning_contacts"] = ["code"=>"system_warning_contacts", "name"=>translate("tr_e483ec82aa15284772779570af27b6b4"), "default_text"=>translate("tr_fb8cbb9f7f9efe014cf480fc5e6581a3")];
    $result["add_to_favorite"] = ["code"=>"add_to_favorite", "name"=>translate("tr_133f79ab2178eac922b6e2f377b3bd31"), "default_text"=>translate("tr_133f79ab2178eac922b6e2f377b3bd31")];
    $result["view_ad_contacts"] = ["code"=>"view_ad_contacts", "name"=>translate("tr_0fdcc5b1907dca97842c2adac32220d7"), "default_text"=>translate("tr_0fdcc5b1907dca97842c2adac32220d7")];
    $result["user_asks_review"] = ["code"=>"user_asks_review", "name"=>translate("tr_3dafc7a392224b5c39c7026e97a48163"), "default_text"=>translate("tr_3dafc7a392224b5c39c7026e97a48163")];
    $result["new_review"] = ["code"=>"new_review", "name"=>translate("tr_86c5c722d85c935e52516e94507b72fc"), "default_text"=>translate("tr_86c5c722d85c935e52516e94507b72fc")];
    $result["response_review"] = ["code"=>"response_review", "name"=>translate("tr_7f2734e6e2c00ae3d7fc03b0086ad448"), "default_text"=>translate("tr_7f2734e6e2c00ae3d7fc03b0086ad448")];
    $result["first_message_support"] = ["code"=>"first_message_support", "name"=>translate("tr_1c57fd7cbed543999891bff2ac6fae08"), "default_text"=>translate("tr_2608c63813ff1c37252597c1e9c3882a")];

    return $result;

} 