public function updateRatingAndReviews($user_id=0){
    global $app;

    $total = $app->model->reviews->count("whom_user_id=? and status=?", [$user_id, 1]);
    $app->model->users->cacheKey(["id"=>$user_id])->update(["total_rating"=>$this->calculateRating($user_id), "total_reviews"=>$total], $user_id);

}