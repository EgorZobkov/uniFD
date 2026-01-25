public function searchCombined($query=null){
    global $app;

    $result = [];
    $answer = '';

    if(_mb_strlen($query) < 2){
        return ["status"=>false];
    }

    $searchSettingsSnippets = $app->model->system_settings_search_snippets->getAll("title LIKE ? or subtitle LIKE ?", ['%'.$query.'%','%'.$query.'%']);

    if($searchSettingsSnippets){
        foreach ($searchSettingsSnippets as $key => $value) {
            $result["settings"][] = ["title"=>$value["title"],"subtitle"=>$value["subtitle"], "link"=>getUrlDashboard().'/'.$value["route_name"]];
        }
    }

    $searchUsers = $app->model->users->getAll("(name LIKE ? or surname LIKE ? or email LIKE ? or phone LIKE ? or alias LIKE ?) limit 30", ['%'.$query.'%','%'.$query.'%','%'.$query.'%','%'.$query.'%','%'.$query.'%']);

    if($searchUsers){
        foreach ($searchUsers as $key => $value) {
            $result["users"][] = ["name"=>$app->user->name($value), "link"=>$app->router->getRoute("dashboard-user-card", [$value['id']])];
        }
    }

    $searchItems = $app->model->ads_data->getAll("(search_tags LIKE ? or text LIKE ? or title LIKE ? or article_number=?) limit 30", ['%'.$query.'%','%'.$query.'%','%'.$query.'%',$query]);

    if($searchItems){
        foreach ($searchItems as $key => $value) {
            $value = $app->component->ads->getDataByValue($value);
            $result["items"][] = ["name"=>$value->title, "link"=>$app->component->ads->buildAliasesAdCard($value)];
        } 
    }

    if($result){
        foreach ($result as $type => $nested) {

            if($type == "users"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_b8c4e70da7bea88961184a1c1be9cb13").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" >
                        <span class="header-search-results-item-title" >'.$value["name"].'</span>                        
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }elseif($type == "items"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" target="_blank" >
                        <span class="header-search-results-item-title" >'.$value["name"].'</span>                        
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }elseif($type == "settings"){

                 $answer .= '
                    <div class="header-search-results-box-items" >
                      <p>'.translate("tr_c919d65bd95698af8f15fa8133bf490d").'</p>
                ';

                foreach ($nested as $key => $value) {
                    $answer .= '
                      <a class="header-search-results-item" href="'.$value["link"].'" >
                        <span class="header-search-results-item-title" >'.$value["title"].'</span>      
                        <span class="header-search-results-item-subtitle">'.$value["subtitle"].'</span>                  
                      </a>
                    ';
                }

                 $answer .= '
                    </div>
                ';

            }

        }
        return ["status"=>true, "answer"=>$answer];
    }

    return ["status"=>false];

} 