public function filtersRequired($filters = [], $category_id = 0){
     global $app;

     $result = [];

     $getIdFilters = $app->component->ads_filters->getFiltersByCategory($category_id);

     if($getIdFilters){

         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                if($value["required"]){

                    if($value["view"] == "input"){

                        $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                        
                        if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                            $result[] = translate("tr_e5a1dbbc446598bc2ae7b4ae3318ea76")." ".$value["name"]." ".translate("tr_7f164d12155a14bdb34181b6f8c41f3f")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                        }

                    }else{

                        if($value["parent_id"]){

                            if($filters[$value["parent_id"]][0]){ 

                                $filterItem = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$value["id"], $filters[$value["parent_id"]][0]]);

                                if($filterItem){
                                    if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                        $result[] = translate("tr_bd9b6163fccd3d74dcba6a2040d91bbb") . " " . $value["name"];

                                    }
                                }

                            }

                        }else{

                            if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                $result[] = translate("tr_bd9b6163fccd3d74dcba6a2040d91bbb") . " " . $value["name"];

                            }                            

                        }

                    }

                }else{

                    if($value["view"] == "input"){

                        if($filters[$value["id"]][0]){

                            $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                            
                            if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                                $result[] = translate("tr_e5a1dbbc446598bc2ae7b4ae3318ea76")." ".$value["name"]." ".translate("tr_7f164d12155a14bdb34181b6f8c41f3f")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                            }

                        }

                    }                        

                }

            }

         }

     }

     return $result;

}