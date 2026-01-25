public function setTimeLastActivity($user_id=0){
    global $app;
    $app->model->users->update(["time_last_activity"=>$app->datetime->getDate()], $user_id);
}