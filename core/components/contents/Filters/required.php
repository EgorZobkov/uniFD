public function required($filters = [], $category_id = 0){
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

                            $result["filter".$value["id"]] = translate("tr_2ea71bfcae51fae6575e527f528611a6")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                        }

                    }else{

                        if($value["parent_id"]){

                            if($filters[$value["parent_id"]][0]){ 

                                $filterItem = $app->model->ads_filters_items->getAll("filter_id=? and item_parent_id=?", [$value["id"], $filters[$value["parent_id"]][0]]);

                                if($filterItem){
                                    if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                        $result["filter".$value["id"]] = translate("tr_bca62e8bb39a76f12905896f5388d8ac");

                                    }
                                }

                            }

                        }else{

                            if(!$filters[$value["id"]][0] || $filters[$value["id"]][0] == ""){ 

                                $result["filter".$value["id"]] = translate("tr_bca62e8bb39a76f12905896f5388d8ac");

                            }                            

                        }

                    }

                }else{

                    if($value["view"] == "input"){

                        if($filters[$value["id"]][0]){

                            $items = $app->model->ads_filters_items->getAll("filter_id=?", [$value["id"]]);
                            
                            if($filters[$value["id"]][0] < $items[0]["name"] || $filters[$value["id"]][0] > $items[1]["name"]){ 

                                $result["filter".$value["id"]] = translate("tr_2ea71bfcae51fae6575e527f528611a6")." ".$items[0]["name"]." ".translate("tr_538dc63d3c6db1a1839cafbaf359799b")." ".$items[1]["name"];

                            }

                        }

                    }                        

                }

            }

         }

     }

     return $result;

}