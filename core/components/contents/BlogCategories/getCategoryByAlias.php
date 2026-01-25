public function getCategoryByAlias($alias=null){
    global $app;

    $results = [];

    $result = $app->model->blog_categories->getRow("alias=?", [$alias]);

    return $result;

}