public function countFiltersIsNotDefault($category_id=0){
    global $app;

    $filters_id = $this->getFiltersByCategory($category_id);

    if(!$filters_id) return 0;

    return $app->model->ads_filters->count("status=? and parent_id=? and default_status=? and id IN(".implode(",", $filters_id).")", [1,0,0]);

}