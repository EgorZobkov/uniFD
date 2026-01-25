public function searchItemsCombined($query=null, $user_id=0){
    global $app;

    $geo = $app->session->get("geo");
    $session_id = $app->session->get("user-session-id");

    $result = [];
    $answer = '';
    $words = [];

    $real_query = $query;
    $data = $this->splitKeywords($query);

    $query = $data["query"];

    if(_mb_strlen($query) < 2){

        if($session_id){

            $getRequests = $app->model->search_requests->getAll("session_id=? order by id desc limit 15", [$session_id]);

            if($getRequests){

                foreach ($getRequests as $key => $value) {

                    if($value["keyword_id"]){

                        $keyword = $app->model->search_keywords->find("id=?", [$value["keyword_id"]]);

                        if($keyword){

                            if($keyword->goal_type == 1){
                                if($keyword->geo_link_status){
                                    if($geo){
                                        $value["link"] = outLink($geo->alias . '/' . trim($keyword->link, "/"));
                                    }else{
                                        $value["link"] = outLink($value["link"]);
                                    }
                                }else{
                                    $value["link"] = outLink($value["link"]);
                                }
                            }elseif($keyword->goal_type == 2){
                                $category = $app->component->ads_categories->categories[$keyword->category_id];
                                $value["link"] = $app->component->ads_categories->buildAliases($category);
                            }elseif($keyword->goal_type == 3){
                                $category = $app->component->ads_categories->categories[$keyword->category_id];
                                $value["link"] = $app->component->ads_categories->buildAliases($category).'?'.$keyword->link;
                            }

                        }else{
                            $value["link"] = outLink($value["link"]);
                        }

                    }else{

                        if(!$value["link"]){
                            $value["link"] = $app->component->catalog->currentAliases() . "?search=".$value["name"];
                        }else{
                            if($value["marker"] == "filter"){
                                if($geo){
                                    $value["link"] = outLink($geo->alias . '/' . trim($value["link"], "/"));
                                }else{
                                    $value["link"] = outLink($value["link"]);
                                }
                            }else{
                                $value["link"] = outLink($value["link"]);
                            }
                        }                        

                    }
                    
                    $answer .= '<a href="'.$value["link"].'" class="live-search-results-item" >'.$value["name"].'</a>';

                }

                return ["status"=>true, "answer"=>$answer];   

            }  

        }  

        return ["status"=>false]; 

    }

    $keywords["query"][] = 'name LIKE ?';
    $keywords["params"][] = '%'.$query.'%';

    if($data["split"]){

        foreach ($data["split"] as $key => $value) {
            if(mb_strlen(trim($value), "UTF-8") > 1){
                $words[] = trim($value);
            }
        }

        if(count($words) == 1){

            $keywords["query"][] = "(name LIKE ? or tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[0].'%';

        }elseif(count($words) == 2){
          
            $keywords["query"][] = "(name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';

        }elseif(count($words) == 3){
            
            $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';

        }elseif(count($words) == 4){
            
            $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';

        }elseif(count($words) == 5){
            
            $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';
            $keywords["params"][] = '%'.$words[4].'%';
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';
            $keywords["params"][] = '%'.$words[4].'%';

        }elseif(count($words) == 6){
            
            $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';
            $keywords["params"][] = '%'.$words[4].'%';
            $keywords["params"][] = '%'.$words[5].'%';
            $keywords["params"][] = '%'.$words[0].'%';
            $keywords["params"][] = '%'.$words[1].'%';
            $keywords["params"][] = '%'.$words[2].'%';
            $keywords["params"][] = '%'.$words[3].'%';
            $keywords["params"][] = '%'.$words[4].'%';
            $keywords["params"][] = '%'.$words[5].'%';

        }

    }

    if(compareValues($app->settings->search_allowed_tables, "keywords")){

        $searchKeywords = $app->model->search_keywords->getAll(implode(" or ", $keywords["query"])." limit 50", $keywords["params"]);

        if($searchKeywords){
            foreach ($searchKeywords as $key => $value) {

                if($value["goal_type"] == 1){
                    if($value["geo_link_status"]){
                        if($geo){
                            $result["keywords"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$this->buildLink(outLink($geo->alias . '/' . trim($value["link"], "/")), $value["id"], "keyword")];
                        }else{
                            $result["keywords"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$this->buildLink($value["link"], $value["id"], "keyword")];
                        }
                    }else{
                        $result["keywords"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$this->buildLink($value["link"], $value["id"], "keyword")];
                    }
                }elseif($value["goal_type"] == 2){
                    $category = $app->component->ads_categories->categories[$value["category_id"]];
                    $result["keywords"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$this->buildLink($app->component->ads_categories->buildAliases($category), $value["id"], "keyword"), "subtitle"=>"<span>".translateFieldReplace($category, "name")."</span>"];
                }elseif($value["goal_type"] == 3){
                    $category = $app->component->ads_categories->categories[$value["category_id"]];
                    $result["keywords"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$this->buildLink($app->component->ads_categories->buildAliases($category).'?'.$value["link"], $value["id"], "keyword"), "subtitle"=>"<span>".translateFieldReplace($category, "name")."</span>"];
                }
        
            }
        }

    }

    if(compareValues($app->settings->search_allowed_tables, "filters")){

        $itemQuery = $this->buildKeywordsFields($data["split"], ["name"]);

        $itemQuery["query"] = "(".$itemQuery["query"].") limit 10";

        $searchFiltersLink = $app->model->ads_filters_links->getAll($itemQuery["query"], $itemQuery["params"]);

        if($searchFiltersLink){
            foreach ($searchFiltersLink as $key => $value) {
                $result["filter"][] = ["name"=>translateFieldReplace($value, "name"), "link"=>$app->component->ads_filters->buildAliasesLink($value).'?s_marker=filter'];
            }
        }

    }

    if(compareValues($app->settings->search_allowed_tables, "shops")){

        if($app->settings->search_allowed_text){
            $itemQuery = $this->buildKeywordsFields($data["split"], ["title", "text"]);
        }else{
            $itemQuery = $this->buildKeywordsFields($data["split"], ["title"]);
        }

        $itemQuery["query"] = "(".$itemQuery["query"].") and status=? limit 10";
        $itemQuery["params"][] = 'published';

        $searchShops = $app->model->shops->getAll($itemQuery["query"], $itemQuery["params"]);

        if($searchShops){
            foreach ($searchShops as $key => $value) {
                $result["shop"][] = ["name"=>$value["title"], "link"=>$app->component->shop->linkToShopCard($value["alias"]).'?s_marker=shop', "subtitle"=>"<span>".translate("tr_8b1d96f8de04890d0139a4ced65111b8")."</span>"];
            }            
        }

    }

    if(compareValues($app->settings->search_allowed_tables, "ads")){

        if($app->settings->search_allowed_text){
            $itemQuery = $this->buildKeywordsFields($data["split"], ["search_tags", "title", "text", "article_number"]);
        }else{
            $itemQuery = $this->buildKeywordsFields($data["split"], ["search_tags", "title", "article_number"]);
        }

        $itemQuery["query"] = "((".$itemQuery["query"].") or title LIKE ?) and status=? limit 10";
        $itemQuery["params"][] = "%".$real_query."%";
        $itemQuery["params"][] = 1;

        $searchItems = $app->model->ads_data->getAll($itemQuery["query"], $itemQuery["params"]);

        if($searchItems){
            foreach ($searchItems as $key => $value) {
                $value = $app->component->ads->getDataByValue($value);
                $result["items"][] = ["name"=>$value->title, "link"=>$app->component->ads->buildAliasesAdCard($value).'?s_marker=ad', "subtitle"=>"<span>".translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d")."</span>"];
            } 
        }

    }

    if($result){
        foreach ($result as $type => $nested) {
            foreach ($nested as $key => $value) {
                $answer .= '<a href="'.$value["link"].'" class="live-search-results-item actionItemSearchClick" data-query="'.$value["name"].'" >'.$value["name"].$value["subtitle"].'</a>';
            }
        }
        return ["status"=>true, "answer"=>$answer];
    }

    return ["status"=>false];

}