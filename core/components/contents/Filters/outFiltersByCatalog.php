 public function outFiltersByCatalog($filters=[], $category_id=0, $only_default_filters=true){
     global $app;

      $result = '';

      $filters_id = $this->getFiltersByCategory($category_id);

      if(!$filters_id) return '';

      if($only_default_filters){
         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and default_status=? and id IN(".implode(",", $filters_id).")", [1,0,1]);
      }else{
         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and parent_id=? and id IN(".implode(",", $filters_id).")", [1,0]);
      }

      if($getFilters){

         foreach ($getFilters as $key => $value) {

             $result .= $this->getFiltersItemsAndViewByCatalog($filters, $value);

             if($filters[$value["id"]]){
                 $result .= $this->getFiltersParentByCatalog($filters, $value["id"], $filters[$value["id"]][0]);
             }

         }

      }

      return $result;

 }