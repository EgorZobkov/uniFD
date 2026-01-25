public function addSelectedFilterItemsAd($filters = [], $category_id = 0, $ad_id = 0){
    global $app;

    $app->model->ads_filters_ids->delete("ad_id=?", [$ad_id]);

    if($filters){

        foreach ($filters as $filter_id => $nested) {

            $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id,1]);

            if($getFilter){

                foreach ($nested as $key => $item) {
                    if(isset($item)){

                        if($getFilter->view == "input"){
                            if($item) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>0,"value"=>round($item,2),"ad_id"=>$ad_id]);
                        }elseif($getFilter->view == "input_text"){
                            if($item) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>0,"value"=>$item,"ad_id"=>$ad_id]);
                        }else{
                            if(intval($item)) $app->model->ads_filters_ids->insert(["filter_id"=>$filter_id,"item_id"=>intval($item),"value"=>null,"ad_id"=>$ad_id]);
                        }

                    }
                }

            }

        }

    }

    $app->caching->delete($app->caching->buildKey("uni_ads_filters_ids", ["ad_id"=>$ad_id]));

}