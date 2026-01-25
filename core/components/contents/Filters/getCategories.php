public function getCategories($filter_id=0){
    global $app;

    $ids = [];

    $getCategories = $app->model->ads_filters_categories->getAll("filter_id=?", [$filter_id]);

    if($getCategories){
        foreach ($getCategories as $key => $value) {
            $ids[] = $value["category_id"];
        }
    }

    return $ids;

}