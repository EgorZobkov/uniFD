public function outFiltersInAdCreate($category_id=0, $ad_id=0){
    global $app;

     $result = '';
     $ad_filters = [];

     $filters_id = $this->getFiltersByCategory($category_id);

     if($ad_id){
        $getAdFilters = $app->model->ads_filters_ids->getAll("ad_id=?", [$ad_id]);
        if($getAdFilters){
            foreach ($getAdFilters as $value) {
                if($value["item_id"]){
                    $ad_filters[$value["filter_id"]][] = $value["item_id"];
                }else{
                    $ad_filters[$value["filter_id"]][] = $value["value"];
                }
            }
        }
     }

     if(!$filters_id) return '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewInAdCreate($value,0,$ad_filters);

            if($ad_filters[$value["id"]]){
                $result .= $this->getFiltersParentInAdCreate($value["id"],$ad_filters[$value["id"]][0],$ad_filters);
            }

        }

     }

     return $result;

}