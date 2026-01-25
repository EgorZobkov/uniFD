public function buildFiltersApp($params=[]){
    global $app;

    $result = [];
    $filters = [];

    if($params){

        if($params["search"]){
            $result["search"] = $params["search"];
        }

        if($params["price_from"]){
            $result["price_from"] = $params["price_from"];
        }

        if($params["price_to"]){
            $result["price_to"] = $params["price_to"];
        }

        if($params["calendar_date_start"]){
            $result["calendar_date_start"] = date("d.m.Y", strtotime($params["calendar_date_start"]));
        }

        if($params["calendar_date_end"]){
            $result["calendar_date_end"] = date("d.m.Y", strtotime($params["calendar_date_end"]));
        }

        if($params["switch"]["urgently"]){
            $result["urgently"] = true;
        }

        if($params["switch"]["delivery"]){
            $result["delivery_status"] = true;
        }

        if($params["switch"]["only_new"]){
            $result["condition_new_status"] = true;
        }

        if($params["switch"]["only_brand"]){
            $result["condition_brand_status"] = true;
        }

        foreach ($params as $filter_id => $nested) {
            if(intval($filter_id)){

                $filter = $app->model->ads_filters->find("id=? and status=?", [(int)$filter_id, 1]);

                if($filter){
                    if($filter->view == "input"){
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>(int)$params[$filter_id]["from"] ? substr($params[$filter_id]["from"], 0, 20) : '', "field"=>"start"];
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>(int)$params[$filter_id]["to"] ? substr($params[$filter_id]["to"], 0, 20) : '', "field"=>"end"];
                    }elseif($filter->view == "input_text"){
                        $filters[] = ["filterId"=>(string)$filter_id, "item"=>$params[$filter_id][0] ? substr($params[$filter_id][0], 0, 50) : '', "field"=>"text"];
                    }else{

                        foreach ($nested as $item_id) {
                            $item = $app->model->ads_filters_items->find("filter_id=? and id=?", [(int)$filter_id, (int)$item_id]);
                            if($item){
                                $filters[] = ["filterId"=>(string)$filter_id, "item"=>(string)$item_id, "name"=>(string)$item->name];
                            }
                        }

                    }
                }

            }
        }

        if($filters){
            $result["filters"] = $filters;
        }

    }

    return $result;

}