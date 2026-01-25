public function changeStatus($review_id=0){
    global $app;

    $review = $app->model->reviews->find("id=?", [$review_id]);

    if($review){
        $app->model->reviews->update(["status"=>1],$review_id);
        $app->component->profile->updateRatingAndReviews($review->whom_user_id);
        $app->component->ads->updateRatingAndReviews($review->whom_user_id, $review->item_id);
        $app->event->changeStatusReview(["item_id"=>$review->item_id, "from_user_id"=>$review->from_user_id, "whom_user_id"=>$review->whom_user_id, "status"=>1]);
    }

}