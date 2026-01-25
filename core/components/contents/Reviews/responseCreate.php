public function responseCreate($params=[]){
    global $app;

    $review = $app->model->reviews->find("id=? and status=? and (from_user_id=? or whom_user_id=?)", [$params["review_id"],1,$params["user_id"],$params["user_id"]]);

    if($params["text"] && $review){
        $app->model->reviews->insert(["item_id"=>$review->item_id, "from_user_id"=>$params["user_id"], "whom_user_id"=>$review->from_user_id, "text"=>$params["text"], "time_create"=>$app->datetime->getDate(), "parent_id"=>$params["review_id"], "status"=>1]);
        $app->event->createResponseReview(["item_id"=>$review->item_id, "from_user_id"=>$params["user_id"], "whom_user_id"=>$review->from_user_id]);
    }

}