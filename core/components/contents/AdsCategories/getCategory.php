public function getCategory($id=0){
    global $app;

    $results = [];

    $result = $app->model->ads_categories->cacheKey(["id"=>$id])->getRow("id=?", [$id]);

    return $result;

}