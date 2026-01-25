public function getTotalUsersActive(){   
    global $app;

    return numberFormat($app->model->users->count("status=?", [1]));

}