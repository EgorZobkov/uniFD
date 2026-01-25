public function getCountByStatus($status=null){
    global $app;

    if(isset($status)){
        return numberFormat($app->model->ads_data->count("status=?", [$status]),0,'.', ' ');
    }

    return 0;
}