public function deleteDialogue($user_id=0, $dialogue_id=0){
    global $app;

    $app->model->chat_dialogues->delete("user_id=? and id=?", [$user_id,$dialogue_id]);
    $app->model->chat_messages->delete("user_id=? and dialogue_id=?", [$user_id,$dialogue_id]);

}