public function uploadedCount($import_id=0, $table=null){
    global $app;

    if($table == "ads"){
        return $app->model->ads_data->count("import_id=?", [$import_id]);
    }elseif($table == "users"){
        return $app->model->users->count("import_id=?", [$import_id]);
    }elseif($table == "blog_posts"){
        return $app->model->blog_posts->count("import_id=?", [$import_id]);
    }

    return 0;

}