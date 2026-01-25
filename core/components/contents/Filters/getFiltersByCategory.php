public function getFiltersByCategory($category_id=0){
    global $app;

    $ids = [];

    $getCategories = $app->model->ads_filters_categories->getAll("category_id=?", [$category_id]);

    if($getCategories){
        foreach ($getCategories as $key => $value) {
            $ids[] = $value["filter_id"];
        }
    }

    return $ids;

}