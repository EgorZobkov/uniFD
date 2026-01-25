public function categoriesData($value=[]){
    global $app;

    $parent = $app->model->ads_categories->find("parent_id=? and status=?", [$value["id"],1]);

    $chain_array = $app->component->ads_categories->getParentsId($value["id"]);

    $breadcrumb = $app->component->ads_categories->getBuildNameChain($chain_array);

    return [
        "id"=>$value["id"],
        "name"=>translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
        "image"=>$app->storage->name($value["image"])->exist() ? $app->storage->name($value["image"])->host(true)->get() : null,
        "subcategory"=>$parent ? true : false,
        "breadcrumb"=>$breadcrumb,
    ];

}