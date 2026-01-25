public function getFiltersParentByCatalog($filters=[], $filter_id=0, $item_id=0){
     global $app;

     $result = '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=?", [1,$filter_id]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewByCatalog($filters, $value,$item_id);

            if($filters[$value["id"]]){
                $result .= $this->getFiltersParentByCatalog($filters, $value["id"], $filters[$value["id"]][0]);
            }

        }

     }

     return $result;

}