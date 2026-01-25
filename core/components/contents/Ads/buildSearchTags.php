public function buildSearchTags($params=[], $geo=[]){
    global $app;

    $filter_items = [];
    $result = [];

    $result[] = $params["article_number"];
    $result[] = $params["title"];
    $result[] = $params["price"];
    $result[] = $app->component->ads_categories->categories[$params['category_id']]["name"];

    if($geo){
        $result[] = $geo->name;
    }

    if($params["filter"]){

        foreach ($params["filter"] as $filter_id => $nested) {
            $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id,1]);
            if($getFilter){
                if($getFilter->view != "input" && $getFilter->view != "input_text"){
                    foreach ($nested as $key2 => $value) {
                        $filter_items[] = $value;
                    }
                }
            }
        }

        if($filter_items){
            
            $filters = $app->model->ads_filters_items->getAll("id IN(".implode(",",$filter_items).")");

            if($filters){
                foreach ($filters as $key => $value) {
                    $result[] = $value["name"];
                }
            }

        }

    }

    return implode(",", $result);
}