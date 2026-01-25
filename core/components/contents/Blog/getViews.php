public function getViews($post_id=0){
    global $app;

    return $app->model->blog_posts_views->count("post_id=?", [$post_id]);

}