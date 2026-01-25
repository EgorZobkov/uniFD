public function delete($id=0){
    global $app;

    $parent_filter_ids = $this->getParentIds($id);
    if($parent_filter_ids){
        foreach (explode(",", $parent_filter_ids) as $filter_id) {
            $app->model->ads_filters->delete("id=?", [$filter_id]);
            $app->model->ads_filters_categories->delete("filter_id=?", [$filter_id]);
            $app->model->ads_filters_ids->delete("filter_id=?", [$filter_id]);
            $app->model->ads_filters_items->delete("filter_id=?", [$filter_id]);
        }
    }

    $app->model->ads_filters->delete("id=?", [$id]);
    $app->model->ads_filters_categories->delete("filter_id=?", [$id]);
    $app->model->ads_filters_ids->delete("filter_id=?", [$id]);
    $app->model->ads_filters_items->delete("filter_id=?", [$id]);

}