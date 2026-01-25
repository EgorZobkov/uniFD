public function buildAliasesLink($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    $chain = $app->component->ads_categories->chainCategory($data["category_id"]);

    if($geo){
        return outLink($geo->alias . '/' . $chain->chain_build_alias_request . '/' . translateFieldReplace($data, "alias"));
    }else{
        return outLink($chain->chain_build_alias_request . '/' . translateFieldReplace($data, "alias"));
    }

}