public function getCountFreePublicationsByUser($user_id=0, $category_id=0){
    global $app;
    return $app->model->ads_free_publications->count("user_id=? and category_id=?", [$user_id,$category_id]);
}