public function generationTitle($filters = [], $category_id = 0){
     global $app;

     $title = $app->component->ads_categories->categories[$category_id]["filter_template_title"];
     
     if(!$title){
         return $app->component->ads_categories->categories[$category_id]["name"];
     }

     $getIdFilters = $app->component->ads_filters->getFiltersByCategory($category_id);

     if($getIdFilters){

         $getFilters = $app->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                if($filters[$value["id"]][0]){ 


                    if($value["view"] == "input" || $value["view"] == "input_text"){
                        $title = str_replace('{'.$value["id"].'}', $filters[$value["id"]][0], $title);
                    }else{
                        $item = $app->model->ads_filters_items->find("filter_id=? and id=?", [$value["id"],$filters[$value["id"]][0]]);
                        if($item){
                            $title = str_replace('{'.$value["id"].'}', $item->name, $title);
                        }else{
                            $title = str_replace('{'.$value["id"].'}', "", $title);
                        }
                    }

                }
                
            }

            return $title ?: $app->component->ads_categories->categories[$category_id]["name"];

         }

     }

}