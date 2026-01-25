public function deleteFullDialogue($user_id=0, $dialogue_id=0){
    global $app;

    $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [$user_id,$dialogue_id]);

    $app->model->chat_dialogues->delete("user_id=? and hash_id=?", [$user_id, $getDialogue->hash_id]);
    $app->model->chat_messages->delete("hash_id=? and action is null", [$getDialogue->hash_id]);

}