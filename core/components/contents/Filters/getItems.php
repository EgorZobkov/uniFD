public function getItems($value=[], $item_id=0){
    global $app;

    if($value["item_sorting"] == "manual"){
        $sorting = 'sorting asc';
    }else{
        $sorting = 'name asc';
    }

    if($item_id){
        return $app->model->ads_filters_items->sort($sorting)->getAll("filter_id=? and item_parent_id=?", [$value["id"],$item_id]);
    }else{
        return $app->model->ads_filters_items->sort($sorting)->getAll("filter_id=?", [$value["id"]]);
    }

}