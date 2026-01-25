public function getCategory($id=0){
    global $app;

    $results = [];

    $result = $app->model->blog_categories->getRow("id=?", [$id]);

    return $result;

}