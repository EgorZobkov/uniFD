public function getData($user_id=0){
    global $app;
    return $app->model->users->findById($user_id, true);
}