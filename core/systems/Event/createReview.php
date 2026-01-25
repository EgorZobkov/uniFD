public function createReview($data = []){
    global $app;

    if(!$app->settings->reviews_publication_moderation_status){
        $app->component->chat->sendAction("new_review", ["from_user_id"=>$data["from_user_id"], "ad_id"=>$data["item_id"], "whom_user_id"=>$data["whom_user_id"]], false);
    }

    $app->notify->params((array)$data)->code("system_create_review")->addWaiting();

}