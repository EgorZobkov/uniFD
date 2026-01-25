public function getCategories(){
    global $app;

    $results = [];

    $categories = $app->model->blog_categories->sort("sorting asc")->getAll("status=?", [1]);
    if($categories){
        foreach ($categories as $key => $value) {
            $results["parent_id"][$value["parent_id"]][$value["id"]] = $value;
            $results["alias"][translateFieldReplace($value, "alias")][$value["id"]] = $value;
            $results[$value["id"]] = $value;
        }
    }

    return $results;

}