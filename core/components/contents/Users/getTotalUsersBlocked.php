public function getTotalUsersBlocked(){   
    global $app;

    return numberFormat($app->model->users->count("status=?", [2]));

}