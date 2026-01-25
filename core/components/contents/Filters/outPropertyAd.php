public function outPropertyAd($ad_id=0, $filters_ids=[], $out_array=false){
    global $app;

    $result = [];
    $group = [];
    $items = [];

    if($filters_ids){
        $getFilters = $app->model->ads_filters_ids->cacheKey(["ad_id"=>$ad_id, "filter_id"=>implode(",",$filters_ids)])->getAll("ad_id=? and filter_id IN(".implode(",",$filters_ids).")", [$ad_id]);
    }else{
        $getFilters = $app->model->ads_filters_ids->cacheKey(["ad_id"=>$ad_id])->getAll("ad_id=?", [$ad_id]);
    }

    if($getFilters){

        foreach ($getFilters as $value) {

            $group[$value["filter_id"]][] = $value["item_id"] ? $value["item_id"] : $value["value"];

        }

        if($group){

            foreach ($group as $filter_id => $nested) {

                $items = [];

                $getFilter = $app->model->ads_filters->find("id=?", [$filter_id]);

                if($getFilter){

                    if($getFilter->view == "input" || $getFilter->view == "input_text"){

                        foreach ($nested as $key => $value) {

                            $items[] = $value;

                        }

                    }else{

                        foreach ($nested as $key => $value) {

                            $getFilterItem = $app->model->ads_filters_items->cacheKey(["id"=>$value, "filter_id"=>$filter_id])->find("id=? and filter_id=?", [$value,$filter_id]);
                            if($getFilterItem){
                                $items[] = translateFieldReplace($getFilterItem, "name");
                            }

                        }

                    }

                    if($items){

                        if(!$out_array){
                            $result[] = '<div class="list-properties-item" ><span>'.translateFieldReplace($getFilter, "name").':</span> '.implode(", ", $items).'</div>';
                        }else{
                            $result[translateFieldReplace($getFilter, "name")] = implode(", ", $items);
                        }

                    }                       

                }

            }

        }


    }

    if(!$out_array){
        return implode("", $result);
    }else{
        return $result; 
    }

}