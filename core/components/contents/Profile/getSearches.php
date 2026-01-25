public function getSearches($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_searches->pagination($_GET['page'],30)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {

            $geo = [];
            $category = [];

            if($value["category_id"]){
                $category = $app->component->ads_categories->categories[$value["category_id"]];
                if($category){
                    $category["chain"] = $app->component->ads_categories->chainCategory($value["category_id"]);
                }
            }

            if($value["city_id"]){
                $geo = $app->model->geo_cities->find("id=?", [$value["city_id"]]);
            }elseif($value["region_id"]){
                $geo = $app->model->geo_regions->find("id=?", [$value["region_id"]]);
            }elseif($value["country_id"]){
                $geo = $app->model->geo_countries->find("id=?", [$value["country_id"]]);
            }

            $value["params"] = $value["params"] ? _json_decode($value["params"]) : [];
           
            $content .= $app->view->setParamsComponent(['value'=>(object)$value, "category"=>(object)$category, "geo"=>$geo])->includeComponent('items/profile-searches-list.tpl');

        }
    }

    return $content;
    
}