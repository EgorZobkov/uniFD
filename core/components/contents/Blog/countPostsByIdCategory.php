public function countPostsByIdCategory($category_id=0){
    global $app;

    return $app->model->blog_posts->count("category_id IN(".$app->component->blog_categories->joinId($category_id)->getParentIds($category_id).")");

}