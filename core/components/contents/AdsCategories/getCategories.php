public function getCategories($ids=null){
    global $app;

    $results = [];

    if($ids){
        $categories = $app->model->ads_categories->sort("sorting asc")->getAll("id IN(".$ids.") and status=?", [1]);
    }else{
        $categories = $app->model->ads_categories->sort("sorting asc")->getAll("status=?", [1]);
    }

    if($categories){
        foreach ($categories as $key => $value) {
            $results["parent_id"][$value["parent_id"]][$value["id"]] = $value;
            $results["alias"][translateFieldReplace($value, "alias")][$value["id"]] = $value;
            $results[$value["id"]] = $value;
        }
    }

    return $results;

}