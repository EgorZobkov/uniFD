public function getCategoryByAlias($alias=null,$only_main=false){

    global $app;

    $results = [];

    if($only_main){
        $result = $app->model->ads_categories->cacheKey(["alias"=>$alias, "parent_id"=>0])->getRow("alias=? and parent_id=?", [$alias,0]);
    }else{
        $result = $app->model->ads_categories->cacheKey(["alias"=>$alias])->getRow("alias=?", [$alias]);
    }

    return $result;
}