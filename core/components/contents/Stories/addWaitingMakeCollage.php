public function addWaitingMakeCollage($item_id=0, $count_day=0, $user_id=0){
    global $app;
    $app->model->stories_waiting_make_collage->insert(["item_id"=>(int)$item_id, "count_day"=>(int)$count_day, "user_id"=>(int)$user_id]);
}