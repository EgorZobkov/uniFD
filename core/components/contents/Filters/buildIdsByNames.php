public function buildIdsByNames($template=null){
    global $app;

    $result = [];
    $exp_tpl = explode("|", $template);

    if($exp_tpl){
        foreach ($exp_tpl as $filter_string) {

            $equally_tpl = explode("=", $filter_string);
            
            if($equally_tpl[0]){
                $getFilter = $app->model->ads_filters->find("name=?", [$equally_tpl[0]]);
                if($getFilter){

                    if($getFilter->view == "input" || $getFilter->view == "input_text"){
                        $result[$getFilter->id][] = $equally_tpl[1];
                    }else{
                        $comma_tpl = explode(",", $equally_tpl[1]);
                        if($comma_tpl){
                            foreach ($comma_tpl as $item_name) {
                               $getFilterItem = $app->model->ads_filters_items->find("filter_id=? and name=?", [$getFilter->id, $item_name]);
                               if($getFilterItem){
                                    $result[$getFilter->id][] = $getFilterItem->id;
                               }
                            }
                        }
                    }

                }
            }

        }
    }

    return $result;

}