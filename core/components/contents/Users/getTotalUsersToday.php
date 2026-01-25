public function getTotalUsersToday(){   
    global $app;

    return numberFormat($app->model->users->count("status=? and date(time_create) = date(now())", [1]));

}