public function buildAliasesCategories($data=[], $shop_alias=null){
    global $app;

    $chain = $app->component->ads_categories->chainCategory($data["id"]);

    return $this->linkToCatalog($shop_alias) . '/' . $chain->chain_build_alias_request;

}