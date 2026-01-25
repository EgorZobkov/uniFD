public function getRemainedCountFreePublicationsByUser($user_id=0, $category_id=0){
    global $app;
    $count = (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"] - $app->model->ads_free_publications->count("user_id=? and category_id=?", [$user_id,$category_id]);
    if(abs($count)){
        return $count;
    }
    return 0;
}