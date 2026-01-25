public function getFilters(){
    global $app;

    $results = [];

    $filters = $app->model->ads_filters->sort("sorting asc")->getAll();
    if($filters){
        foreach ($filters as $key => $value) {
            $results["parent_id"][$value["parent_id"]][$value["id"]] = $value;
            $results["alias"][translateFieldReplace($value, "alias")][$value["id"]] = $value;
            $results[$value["id"]] = $value;
        }
    }

    return $results;

}