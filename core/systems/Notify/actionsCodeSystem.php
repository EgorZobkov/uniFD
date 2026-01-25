public function actionsCodeSystem(){ 
    global $app;

    $result["system_new_users"] = ["code"=>"system_new_users", "name"=>translate("tr_2fbd8719f2595bbe4fc24646e945e9a5")];
    $result["system_new_transaction"] = ["code"=>"system_new_transaction", "name"=>translate("tr_45f8547c14a487ecbd3f6e190adc2e9e")];
    $result["system_chat_new_message"] = ["code"=>"system_chat_new_message", "name"=>translate("tr_363c284d56019dea9412200a37c20815")];
    $result["system_open_dispute_deal"] = ["code"=>"system_open_dispute_deal", "name"=>translate("tr_e1fc430809c38206dce521425fcf125f")];
    $result["system_new_user_verification"] = ["code"=>"system_new_user_verification", "name"=>translate("tr_eda3a8920faa1af794c5af503c98255d")];
    $result["system_open_shop"] = ["code"=>"system_open_shop", "name"=>translate("tr_15ec7acc80d41d1524ad6d61311b3182")];
    $result["system_edit_shop"] = ["code"=>"system_edit_shop", "name"=>translate("tr_47ddd2d7bfd2ade851ca18967474d4d0")];
    $result["system_add_stories"] = ["code"=>"system_add_stories", "name"=>translate("tr_415f4cc4723517ceecf9d92f11796e68")];
    $result["system_create_ad"] = ["code"=>"system_create_ad", "name"=>translate("tr_1abe83d1461657b8e9d5516cc4d82828")];
    $result["system_create_review"] = ["code"=>"system_create_review", "name"=>translate("tr_0cf94cfe98786602760056058733729e")];
    $result["system_add_complaint_user"] = ["code"=>"system_add_complaint_user", "name"=>translate("tr_b68e06d07f106fd117dafd69621b849d")];
    $result["system_add_complaint_ad"] = ["code"=>"system_add_complaint_ad", "name"=>translate("tr_b49622aea11073783fae89184450c5c7")];
    
    return $result;

}