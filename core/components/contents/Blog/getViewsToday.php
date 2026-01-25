public function getViewsToday($post_id=0){
    global $app;

    return $app->model->blog_posts_views->count("post_id=? and date(time_create)=?", [$post_id,$app->datetime->format("Y-m-d")->getDate()]);

}