public function changeStatusReview($data = []){
    global $app;

    $app->component->chat->sendAction("new_review", ["from_user_id"=>$data["from_user_id"], "ad_id"=>$data["item_id"], "whom_user_id"=>$data["whom_user_id"]], false);

}