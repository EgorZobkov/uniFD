public function delete($review_id=0, $user_id=0){
    global $app;

    if($user_id){
        $review = $app->model->reviews->find("id=? and from_user_id=?", [$review_id, $user_id]);
    }else{
        $review = $app->model->reviews->find("id=?", [$review_id]);
    }

    if($review){

        if($review->media){
            foreach (_json_decode($review->media) as $key => $value) {
                $app->storage->name($value)->delete();
            }
        }

        $app->model->reviews->delete("id=?", [$review_id]);
        $app->model->reviews->delete("parent_id=?", [$review_id]);

        $app->component->profile->updateRatingAndReviews($review->whom_user_id);
        $app->component->ads->updateRatingAndReviews($review->whom_user_id, $review->item_id);

    }

}