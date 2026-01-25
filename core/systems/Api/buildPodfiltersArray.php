 function buildPodfiltersArray($filter_id=0, $change_filters=[], $filters=[]){
    global $app;

    $result = [];

    if(isset($filters["parent_id"][$filter_id])){

       foreach ($filters["parent_id"][$filter_id] as $parent_value) {

          $items = [];

          $getItems = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$parent_value["id"],$change_filters[$filter_id]]);

          if($getItems){

             foreach ($getItems as $item) {
                 $ids_podfilter = $app->component->ads_filters->getParentIds($parent_value["id"]);               
                 $items[] = ["name"=>$item["name"], "id"=>$item["id"], "podfilter"=>$app->model->ads_filters_items->find("item_parent_id=?", [$item["id"]]) ? true : false, "ids_podfilter"=>$ids_podfilter ?: null];
             }

             $result[] = [
                 "id" => $parent_value["id"],
                 "view" => $parent_value["view"],
                 "name" => $parent_value["name"],
                 "items" => $items,
                 "required" => $parent_value["required"] ? true : false,
                 "podfilter" => $filters["parent_id"][$parent_value["id"]] ? true : false,
             ];

          }


          if(isset($change_filters[$parent_value["id"]])){

             $parent_filter = $this->buildPodfiltersArray($parent_value["id"], $change_filters, $filters);
             
             if($parent_filter){
                 $result = array_merge($result, $parent_filter);
             }

          }

       }

    }

    return $result ? $result : [];

 }