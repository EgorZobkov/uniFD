public function getTotalUsers(){   
    global $app;

    return numberFormat($app->model->users->count());

}