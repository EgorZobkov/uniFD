public function updateRatingAndReviews($user_id=0, $item_id=0){
    global $app;

    $total = $app->model->reviews->count("whom_user_id=? and item_id=? and status=?", [$user_id, $item_id, 1]);
    $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["total_rating"=>$app->component->profile->calculateRating($user_id, $item_id), "total_reviews"=>$total], $item_id);

}