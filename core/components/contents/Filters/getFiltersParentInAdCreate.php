public function getFiltersParentInAdCreate($filter_id=0, $item_id=0, $ad_filters=[]){
     global $app;

     $result = '';

     $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=?", [1,$filter_id]);

     if($getFilters){

        foreach ($getFilters as $key => $value) {

            $result .= $this->getFiltersItemsAndViewInAdCreate($value,$item_id,$ad_filters);

            if($_POST["filter"][$value["id"]]){
                $result .= $this->getFiltersParentInAdCreate($value["id"],$_POST["filter"][$value["id"]][0],$ad_filters);
            }

        }

     }

     return $result;

}