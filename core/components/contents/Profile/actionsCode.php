public function actionsCode(){   
    global $app;

    $result["buy"] = ["code"=>"buy", "name"=>translate("tr_b00d3a26323497e7f7d36f8887262fd5"), "name_declension"=>translate("tr_bbf3a630e0e4258834b3fbe1b64e60bc")];
    $result["view_ad_contacts"] = ["code"=>"view_ad_contacts", "name"=>translate("tr_26c08f95bbf86858520c006b541d6999"), "name_declension"=>translate("tr_26c08f95bbf86858520c006b541d6999")];
    $result["add_to_cart"] = ["code"=>"add_to_cart", "name"=>translate("tr_bbc1105e6ea90058cfdb2575fa86b408"), "name_declension"=>translate("tr_fa7597ee61cdf0df8fb1083e5553589a")];
    $result["add_to_favorite"] = ["code"=>"add_to_favorite", "name"=>translate("tr_893d62d08d30f5c887cc7491447a0a01"), "name_declension"=>translate("tr_742e5067ef79ea070fbe835c2c29ea80")];
    $result["go_partner_link"] = ["code"=>"go_partner_link", "name"=>translate("tr_9906d2cd832b58290e07028aadbd560b"), "name_declension"=>translate("tr_2e79da4fd1063a4a02acf83b1643d847")];

    return $result;

}