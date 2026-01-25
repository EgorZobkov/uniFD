public function buildQuery($request=[], $category_id=0, $geo=[]){
    global $app;

    $flQueryResult = [];
    $flQuery= [];
    $flCount = 0;
    $filter = $request["filter"];

    $price_from = (int)$filter["price_from"];
    $price_to = (int)$filter["price_to"];

    $query[] = "status=?";
    $params[] = 1;
    $ids = [];
    $ids_not = [];

    if($request["search"]){

        $data = $app->component->search->splitKeywords($request["search"]);

        if($data["split"]){
            
            if($app->settings->search_allowed_text){
                $itemQuery = $app->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "text", "article_number"]);
            }else{
                $itemQuery = $app->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "article_number"]);
            }

            $query[] = "(title LIKE ? or (".$itemQuery["query"]."))";
            $params[] = $request["search"];
            $params = array_merge($params, $itemQuery["params"]);

            $category_id = 0;
        }

    }

    if($price_from && $price_to){  
        $query[] = "(price BETWEEN ? AND ?)";
        $params[] = round($price_from,2);
        $params[] = round($price_to,2);
        unset($filter["price_from"]);
        unset($filter["price_to"]);
    }else{
        if($price_from){
           $query[] = "(price >= ?)";
           $params[] = round($price_from,2);
           unset($filter["price_from"]);
        }elseif($price_to){
           $query[] = "(price <= ?)";
           $params[] = round($price_to,2);
           unset($filter["price_to"]);
        }
    }

    if($filter["switch"]["urgently"]){
       $query[] = "(service_urgently_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["only_new"]){
       $query[] = "(condition_new_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["only_brand"]){
       $query[] = "(condition_brand_status = ?)";
       $params[] = 1;
    }

    if($filter["switch"]["delivery"]){
       $query[] = "(delivery_status = ?)";
       $params[] = 1;
    }

    if($filter["calendar_date_start"] && $filter["calendar_date_end"]){

       $query[] = "(booking_status = ?)";
       $params[] = 1;

       $getBookingDates = $app->model->booking_dates->getAll("(date BETWEEN ? AND ?)", [$filter["calendar_date_start"], $filter["calendar_date_end"]]);
       
       if($getBookingDates){
            foreach ($getBookingDates as $key => $value) {
                $ids_not[$value["ad_id"]] = $value["ad_id"];
            }
       }

    }

    if($category_id){

        $categories_ids = $app->component->ads_categories->joinId($category_id)->getParentIds($category_id);

        if($categories_ids){
            $query[] = "category_id IN (".$categories_ids.")";
        } 

    }

    if($geo){

        if($geo->city_id){
            $query[] = '(city_id=? or city_id=?)';
            $params[] = $geo->city_id;
            $params[] = 0;
        }elseif($geo->region_id){
            $query[] = '(region_id=? or region_id=?)';
            $params[] = $geo->region_id;       
            $params[] = 0;         
        }elseif($geo->country_id){
            $query[] = '(country_id=? or country_id=?)';
            $params[] = $geo->country_id;
            $params[] = 0;                
        }

    }

    if($request["city_districts"]){
        $districts_ids = [];
        if(is_array($request["city_districts"])){
            $getDistricts = $app->model->ads_city_districts_ids->getAll("district_id IN(".implode(",", $request["city_districts"]).")");
            if($getDistricts){
                foreach ($getDistricts as $key => $value) {
                    $districts_ids[] = $value["id"];
                    $ids[$value["ad_id"]] = $value["ad_id"];
                }
            }
        }
    }

    if($request["city_metro"]){
        $metro_ids = [];
        if(is_array($request["city_metro"])){
            $getMetro = $app->model->ads_city_metro_ids->getAll("metro_id IN(".implode(",", $request["city_metro"]).")");
            if($getMetro){
                foreach ($getMetro as $key => $value) {
                    $metro_ids[] = $value["id"];
                    $ids[$value["ad_id"]] = $value["ad_id"];
                }
            }
        }
    }

    unset($filter["switch"]);

    if($filter){

       foreach($filter AS $filter_id => $nested){

           $getFilter = $app->model->ads_filters->find("id=? and status=?", [$filter_id, 1]);

           if($getFilter){

             if($getFilter->view != "input" && $getFilter->view != "input_text"){

                 foreach($nested AS $key => $value){
    
                     if($value != "" && $value != "null"){
                         
                         if(!$flQuery[$filter_id]){
                            $flCount++;
                         }

                         $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND item_id='".intval($value)."')";
                         
                     } 
                   
                 }            
            
             }elseif($getFilter->view == "input"){

                $flCount++;
                if($nested["from"] && $nested["to"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND (value BETWEEN ".($nested["from"] ? round($nested["from"],2) : 0)." AND ".($nested["to"] ? round($nested["to"],2) : 0)."))";
                }elseif($nested["from"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value >= ".($nested["from"] ? round($nested["from"],2) : 0).")";
                }elseif($nested["to"]){
                    $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value <= ".($nested["to"] ? round($nested["to"],2) : 0).")";
                }

             }elseif($getFilter->view == "input_text"){

                $flCount++;
                $flQuery[$filter_id][] = "(filter_id='".intval($filter_id)."' AND value = '".$nested[0]."')";

             }

             if($flQuery[$filter_id]){
                $flQueryResult[] = implode(" OR ",$flQuery[$filter_id]);
             }    

           }       
      
       }            

    }

    if($flQueryResult){

         $getItemsIdsFilter = $app->model->ads_filters_ids->getItemsIdsFilter("(".implode(" OR ", $flQueryResult).") GROUP BY ad_id HAVING cnt >= ".$flCount);

         if($getItemsIdsFilter){
             foreach ($getItemsIdsFilter as $value) {
                $ids[$value["ad_id"]] = $value["ad_id"];
             }
         }

         if(!$ids){
            return [];
         }

    }

    if($request["city_districts"] && $request["city_metro"]){
        if($districts_ids && $metro_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($request["city_districts"]){
        if($districts_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($request["city_metro"]){
        if($metro_ids){
            $query[] = 'id IN('.implode(",", $ids).')';
        }else{
            return [];
        }
    }elseif($ids){
        $query[] = 'id IN('.implode(",", $ids).')';
    }

    if($ids_not){
        $query[] = 'id NOT IN('.implode(",", $ids_not).')';
    }

    return ["query"=>implode(" and ", $query), "params"=>$params];

}