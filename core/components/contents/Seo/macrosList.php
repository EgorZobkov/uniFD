public function macrosList(){
    global $app;

    $result = [];

    $result["default"] = [
        "{domain}"=>translate("tr_4ec0e56c9e378b701d1940b5c5cad00d"),
        "{domain_link}"=>translate("tr_4ea570611424bb98dea248be4d549e45"),
        "{project_name}"=>translate("tr_d7d5c6a2145e768e9fc2faf343d093a3"),
        "{project_title}"=>translate("tr_a9f0dc42ef07c1f211c4e66f0ed21c92"),
        "{contact_email}"=>translate("tr_f0665d2543fdd03c64c33f37a213bed2"),
        "{contact_phone}"=>translate("tr_953045b5b1362c28a9252937ff8e6180"),
        "{contact_organization_name}"=>translate("tr_16c3e7e34102c34643e18ddc60acac86"),
        "{contact_organization_address}"=>translate("tr_ca4ea4f9ee2587926e708dc7b1e8d4b6"),
        "{current_geo_name}" => translate("tr_f781269c0d0d28da3de9b8b72bacae58"),
        "{current_geo_name_declension}" => translate("tr_032f990fd4e90ee4843ae8140b5b5cfe"),
        "{current_geo_text}" => translate("tr_01d27d30b89c6edd9aaee494f675d3b1"),
    ];

    $result["catalog"] = [
        "{current_category_name}" => translate("tr_bfa71a08041813ce7a0eaaa2e54e2bdd"),
        "{current_category_title}" => translate("tr_c57de653b54a427cc12f098470e4480b"),
        "{current_category_h1}" => translate("tr_286b9ca697cbe2d9ae99c4899b71c671"),
        "{current_category_desc}" => translate("tr_d99a01f81aa4a178f5b4e53e7400f10c"),
        "{current_category_text}" => translate("tr_a0b7016a3cd2e92b4812239ae39fe6a9"),
    ];

    $result["ad-card"] = [
        "{ad_title}" => translate("tr_a9a8a2633f167c218777464f76c20065"),
        "{ad_text}" => translate("tr_d52903a8cc07f11a84ce2a2d9876bee8"),
        "{ad_price}" => translate("tr_7137e74270dd85fd4cf38c7c1f9b6a79"),
        "{ad_category_name}" => translate("tr_f45526a9def82fc3d462483d96bb6a4f"),
        "{ad_category_meta_title}" => translate("tr_cd0fa2eeb44bf90f622cc57845677f10"),
        "{ad_category_meta_desc}" => translate("tr_3e08fe17e38152c72bd4c7d30804598c"),
        "{ad_category_h1}" => translate("tr_9d3825147e3aa0aef5c7f3bb61145f9a"),
        "{ad_category_text}" => translate("tr_a134f419654f56ed9f541e86eeb99958"),
        "{ad_city_name}" => translate("tr_9e918857360a370acce60453b1bbabdf"),
        "{ad_city_name_declension}" => translate("tr_0954fd4659b8060d472b280e0085c2f1"),
        "{ad_city_text}" => translate("tr_7bf58d3a4dba5ad9d141b267908b0639"),
    ];

    $result["user-card"] = [
        "{user_name}" => translate("tr_6fd4b189fe4f5e89b827f2d656082c90"),
        "{user_surname}" => translate("tr_2c690fa3071648516c94002f3f7f51a8"),
        "{total_reviews}" => translate("tr_190907cfcf1b8458292e0fcfa2a8ece8"),
    ];

    $result["user-card-ads"] = [
        "{user_name}" => translate("tr_6fd4b189fe4f5e89b827f2d656082c90"),
        "{user_surname}" => translate("tr_2c690fa3071648516c94002f3f7f51a8"),
        "{total_reviews}" => translate("tr_190907cfcf1b8458292e0fcfa2a8ece8"),
    ];

    $result["shop"] = [
        "{shop_title}" => translate("tr_3cdc231c82998934eb5b805c6ecc1ab6"),
        "{shop_text}" => translate("tr_5083776162344f166ccd9665245d11ef"),
    ];

    $result["shop-catalog"] = [
        "{shop_title}" => translate("tr_3cdc231c82998934eb5b805c6ecc1ab6"),
        "{shop_current_category_name}" => translate("tr_c81511279305f507be3663611b3ac0dc"),
        "{shop_current_category_meta_title}" => translate("tr_21c381bf1812cc5be41162c38a25f3b4"),
        "{shop_current_category_desc}" => translate("tr_9ae80ee0bb3287078c348c5a6c1aeb6f"),
        "{shop_current_category_h1}" => translate("tr_8ee3fa7ad5e2cc4f2eded5af5c71ef0a"),
        "{shop_current_category_text}" => translate("tr_c241f9052a898e3ee5901d2fb52dccba"),
    ];

    $result["blog"] = [
        "{blog_current_category_name}" => translate("tr_bc8456eeaac8bd562cddc65bf9e710c8"),
        "{blog_current_category_meta_title}" => translate("tr_1aefc771bdcd55e04a847e0bb1b3a36c"),
        "{blog_current_category_meta_desc}" => translate("tr_1e4d15ef892b5682c21849dc193c8210"),
        "{blog_current_category_h1}" => translate("tr_b9e2ae3bbd3936af2f27968feb64653d"),
        "{blog_current_category_text}" => translate("tr_cf847b2b522c771a21b7e6d88228e4f3"),
    ];

    $result["blog-post"] = [
        "{post_title}" => translate("tr_567dcfbc22f494558ae1af2afa5f52a0"),
        "{post_desc}" => translate("tr_c77392285dc540de187923e1550506ab"),
    ];

    return $result;
    
}