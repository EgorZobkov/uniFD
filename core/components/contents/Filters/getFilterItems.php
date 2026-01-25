public function getFilterItems($filter_id=0){
    global $app;

    $getFilter = $app->model->ads_filters->find("id=?", [$filter_id]);

    if($getFilter->item_sorting == "abs"){
        return $app->model->ads_filters_items->getAll("filter_id=? order by name asc", [$filter_id]);
    }else{
        return $app->model->ads_filters_items->getAll("filter_id=? order by sorting asc", [$filter_id]);
    }

}