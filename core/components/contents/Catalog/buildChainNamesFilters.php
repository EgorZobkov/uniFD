public function buildChainNamesFilters($params=[], $geo=[]){
    global $app;

    $result = [];

    if($geo){
        $result[] = $geo->name;
    }

    if($params["filter"]["price_from"]){
        $result[] = translate("tr_50b6450b4c1ce87e8874b0fa6879381d")." ".$app->system->amount($params["filter"]["price_from"]);
        unset($params["filter"]["price_from"]);
    }

    if($params["filter"]["price_to"]){
        $result[] = translate("tr_1a0628dfe431c9d920bc2fc206d16216")." ".$app->system->amount($params["filter"]["price_to"]);
        unset($params["filter"]["price_to"]);
    }

    if($params["city_districts"]){
        $result[] = translate("tr_eed248b6d4d4b1363de9fc590de921c2")." ".count($params["city_districts"]);
    }

    if($params["city_metro"]){
        $result[] = translate("tr_fae5417d546768ff2552ea52752e4fe6")." ".count($params["city_metro"]);
    }

    if($params["search"]){
        $result[] = translate("tr_bfc95980634bf529e8a406db2c842b31")." ".$params["search"];
    }

    if($params["sort"]){
        if($params["sort"] == "news"){
           $result[] = translate("tr_67994f179ee9cff8c25e295ed1a7a375");
        }elseif($params["sort"] == "price_asc"){
           $result[] = translate("tr_1ee3ebbb2c276425f26aedde12911cb5");
        }elseif($params["sort"] == "price_desc"){
           $result[] = translate("tr_d57c74946bf3b0f62d3ece8e4d34523b");
        }
    }

    if($params["filter"]){
        $result[] = translate("tr_beb17c7b102f4290331f8480b73bdfc1")." ".count($params["filter"])." ".endingWord(count($params["filter"]), translate("tr_525cf87caa93db1879f3336c1fae54b5"), translate("tr_7a6c3d490cd5136182142ff421e08a6b"), translate("tr_486f855767fbe51af5695abec9681ea5"));
    }

    return $result ? implode(" - ", $result) : '';

}